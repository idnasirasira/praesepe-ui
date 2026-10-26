<x-ui.select
    name="role"
    label="Team role"
    hint="Controls access to invoices, stock, and approvals."
    placeholder="Select a role"
    required
    class="max-w-sm"
>
    <option value="owner">Owner</option>
    <option value="finance">Finance</option>
    <option value="ops">Operations</option>
    <option value="viewer">Viewer</option>
</x-ui.select>
