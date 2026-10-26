import hljs from 'highlight.js/lib/core';
import xml from 'highlight.js/lib/languages/xml';
import javascript from 'highlight.js/lib/languages/javascript';
import css from 'highlight.js/lib/languages/css';
import php from 'highlight.js/lib/languages/php';

hljs.registerLanguage('xml', xml);
hljs.registerLanguage('html', xml);
hljs.registerLanguage('blade', xml);
hljs.registerLanguage('javascript', javascript);
hljs.registerLanguage('css', css);
hljs.registerLanguage('php', php);

export function highlightCodeBlocks(root = document) {
    root.querySelectorAll('pre code[class*="language-"]').forEach((block) => {
        if (block.dataset.highlighted === 'yes') {
            return;
        }

        hljs.highlightElement(block);
    });
}

export { hljs };
