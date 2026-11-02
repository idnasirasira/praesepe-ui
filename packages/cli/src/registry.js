/**
 * @param {string} registryUrl
 * @param {string} slug
 * @returns {Promise<{
 *   slug: string,
 *   name: string,
 *   dependencies: string[],
 *   icons: string[],
 *   files: Array<{ path: string, type: string, content: string, dependency_of: string | null }>
 * }>}
 */
export async function fetchComponentPackage(registryUrl, slug) {
  const url = `${registryUrl.replace(/\/$/, '')}/${slug}.json`;
  const response = await fetch(url);

  if (response.status === 404) {
    throw new Error(`Unknown component: ${slug}`);
  }

  if (!response.ok) {
    throw new Error(`Failed to fetch ${url} (${response.status})`);
  }

  return response.json();
}

/**
 * @param {string} registryUrl
 * @returns {Promise<string>}
 */
export async function fetchThemeCss(registryUrl) {
  const url = `${registryUrl.replace(/\/$/, '')}/styles/theme.css`;
  const response = await fetch(url);

  if (!response.ok) {
    throw new Error(`Failed to fetch ${url} (${response.status})`);
  }

  return response.text();
}

/**
 * Resolve dependency order for a list of root slugs using registry packages.
 *
 * @param {string} registryUrl
 * @param {string[]} slugs
 * @param {(url: string, slug: string) => Promise<{ slug: string, dependencies?: string[], files: Array<{ path: string, type: string, content: string, dependency_of: string | null }> }>} [fetcher]
 */
export async function resolveInstallFiles(registryUrl, slugs, fetcher = fetchComponentPackage) {
  /** @type {Map<string, Awaited<ReturnType<typeof fetchComponentPackage>>>} */
  const cache = new Map();
  /** @type {string[]} */
  const ordered = [];
  /** @type {Record<string, boolean>} */
  const visiting = {};

  async function visit(slug) {
    if (ordered.includes(slug)) {
      return;
    }

    if (visiting[slug]) {
      throw new Error(`Circular dependency involving ${slug}`);
    }

    visiting[slug] = true;

    let pkg = cache.get(slug);
    if (!pkg) {
      pkg = await fetcher(registryUrl, slug);
      cache.set(slug, pkg);
    }

    for (const dependency of pkg.dependencies ?? []) {
      await visit(dependency);
    }

    delete visiting[slug];
    ordered.push(slug);
  }

  for (const slug of slugs) {
    await visit(slug);
  }

  /** @type {Map<string, { path: string, type: string, content: string, dependency_of: string | null }>} */
  const files = new Map();

  for (const slug of ordered) {
    const pkg = cache.get(slug);
    for (const file of pkg.files) {
      if (!files.has(file.path)) {
        files.set(file.path, file);
      }
    }
  }

  return {
    resolved: ordered,
    files: [...files.values()],
  };
}
