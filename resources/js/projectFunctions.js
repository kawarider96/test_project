// CSRF token lekérése a meta tag-ból
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

export async function createProject(name) {
    try {
        const response = await fetch('/projects', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ name }),
        });
        if (!response.ok) throw new Error('Failed to create project');
        return await response.json();
    } catch (error) {
        console.error('Error creating project:', error);
    }
}

export async function fetchProjects() {
    try {
        const response = await fetch('/projects');
        if (!response.ok) throw new Error('Failed to fetch projects');
        return await response.json();
    } catch (error) {
        console.error('Error fetching projects:', error);
    }
}

export async function exportProjects() {
    try {
        const response = await fetch('/projects/export', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });
        if (!response.ok) throw new Error('Failed to export projects');
        return await response.text(); // Visszatérési érték: HTML tartalom
    } catch (error) {
        console.error('Error exporting projects:', error);
    }
}