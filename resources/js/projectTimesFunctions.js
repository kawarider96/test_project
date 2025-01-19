// CSRF token lekérése a meta tag-ból
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

export async function fetchProjectTimes(projectId) {
    try {
        const response = await fetch(`/project-times?project_id=${projectId}`);
        if (!response.ok) throw new Error('Failed to fetch project times');
        return await response.json();
    } catch (error) {
        console.error('Error fetching project times:', error);
    }
}

export async function createProjectTime(projectId, startTime, endTime, comment) {
    try {
        const response = await fetch('/project-times', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                project_id: projectId,
                project_start: startTime,
                project_end: endTime,
                project_comment: comment,
            }),
        });
        if (!response.ok) throw new Error('Failed to create project time');
        return await response.json();
    } catch (error) {
        console.error('Error creating project time:', error);
    }
}

export async function updateProjectTime(projectTimeId, data) {
    try {
        const response = await fetch(`/project-times/${projectTimeId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error('Failed to update project time');
        return await response.json();
    } catch (error) {
        console.error('Error updating project time:', error);
    }
}
