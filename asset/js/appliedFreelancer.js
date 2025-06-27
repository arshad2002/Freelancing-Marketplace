document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const jobId = urlParams.get('job_id');
    if (jobId) {
        fetchFreelancerApplications(jobId);
        console.log(jobId);
    } else {
        console.error('Job ID not found in URL.');
    }
});

function fetchFreelancerApplications(jobId) {
    const applicationListContainer = document.getElementById('applicationList');
    applicationListContainer.innerHTML = '<div class="loading">Loading applications...</div>';
    
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `../controller/appliedFreelance.php?job_id=${jobId}`, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);

            if (data.length > 0) {
                displayApplications(data);
            } else {
                applicationListContainer.innerHTML = '<div class="no-applications">No applications received yet for this job.</div>';
            }
        } else {
            console.error('Error fetching applications:', xhr.statusText);
            applicationListContainer.innerHTML = '<div class="alert alert-danger">Error loading applications. Please refresh the page.</div>';
        }
    };

    xhr.onerror = function () {
        console.error('Network error occurred.');
        applicationListContainer.innerHTML = '<div class="alert alert-danger">Network error. Please check your connection and try again.</div>';
    };

    xhr.send();
}

function displayApplications(applications) {
    const applicationListContainer = document.getElementById('applicationList');
    applicationListContainer.innerHTML = '';

    const ul = document.createElement('ul');
    ul.style.listStyle = 'none';
    ul.style.padding = '0';
    ul.style.margin = '0';

    applications.forEach(function (application) {
        const listItem = document.createElement('li');
        
        // Create CV download link if CV exists
        let cvActions = '';
        if (application.cv_file) {
            cvActions = `<p style="color: var(--text-primary); margin: 0.5rem 0;"><strong style="color: var(--accent-secondary);">CV:</strong> 
                        <a href="../controller/viewCV.php?cv_file=${application.cv_file}&application_id=${application.application_id}" target="_blank" style="color: var(--accent-primary); text-decoration: none;">View CV</a> | 
                        <a href="../controller/downloadCV.php?cv_file=${application.cv_file}&application_id=${application.application_id}" target="_blank" style="color: var(--accent-primary); text-decoration: none;">Download CV</a></p>`;
        } else {
            cvActions = '<p style="color: var(--text-primary); margin: 0.5rem 0;"><strong style="color: var(--accent-secondary);">CV:</strong> Not provided</p>';
        }
        
        // Create work submission info if exists
        let workInfo = '';
        if (application.work_file) {
            workInfo = `<p style="color: var(--text-primary); margin: 0.5rem 0;"><strong style="color: var(--accent-secondary);">Work Submitted:</strong> 
                       <a href="../controller/downloadWork.php?work_file=${application.work_file}&application_id=${application.application_id}" target="_blank" style="color: var(--accent-primary); text-decoration: none;">Download Work</a></p>`;
        }
        if (application.work_description) {
            workInfo += `<p style="color: var(--text-primary); margin: 0.5rem 0;"><strong style="color: var(--accent-secondary);">Work Description:</strong> ${application.work_description}</p>`;
        }
        if (application.work_submitted_date) {
            workInfo += `<p style="color: var(--text-primary); margin: 0.5rem 0;"><strong style="color: var(--accent-secondary);">Submitted on:</strong> ${application.work_submitted_date}</p>`;
        }
        
        // Determine which buttons to show based on status
        let actionButtons = '';
        if (application.status === 'pending') {
            actionButtons = `
                <button onclick="acceptApplication(${application.application_id})" class="btn-accept">Accept</button>
                <button onclick="rejectApplication(${application.application_id})" class="btn-reject">Reject</button>
            `;
        } else if (application.status === 'accepted') {
            actionButtons = `
                <div class="alert alert-info">✓ Accepted - Waiting for work submission</div>
            `;
        } else if (application.status === 'work_submitted') {
            actionButtons = `
                <button onclick="markAsCompleted(${application.application_id})" class="btn-success">Mark as Completed</button>
                <div class="alert alert-warning">Work submitted - Review and mark as completed</div>
            `;
        } else if (application.status === 'completed') {
            actionButtons = `
                <div class="alert alert-success">✓ Completed - Payment processed</div>
            `;
        } else if (application.status === 'rejected') {
            actionButtons = `
                <div class="alert alert-danger">✗ Rejected</div>
            `;
        }
        
        listItem.innerHTML = `
            <div class="application-card">
                <h4>${application.freelancer_name}</h4>
                <p style="color: var(--text-primary); margin: 0.5rem 0;"><strong style="color: var(--accent-secondary);">Email:</strong> ${application.freelancer_email}</p>
                <p style="color: var(--text-primary); margin: 0.5rem 0;"><strong style="color: var(--accent-secondary);">Application:</strong> ${application.application_text}</p>
                <div style="color: var(--text-primary);">${cvActions}</div>
                <div style="color: var(--text-primary);">${workInfo}</div>
                <p style="color: var(--text-primary); margin: 0.5rem 0;"><strong style="color: var(--accent-secondary);">Status:</strong> 
                    <span class="status-badge status-${application.status}">${application.status.replace('_', ' ').toUpperCase()}</span>
                </p>
                <div class="application-actions" style="margin-top: 1rem;">
                    ${actionButtons}
                </div>
            </div>
        `;
        ul.appendChild(listItem);
    });
    
    applicationListContainer.appendChild(ul);
}


function acceptApplication(applicationId) {
    if (confirm('Are you sure you want to accept this application?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `../controller/updateApplicationStatus.php?application_id=${applicationId}&status=accepted`, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(`Application ${applicationId} accepted.`);
                // Refresh the applications list
                const urlParams = new URLSearchParams(window.location.search);
                const jobId = urlParams.get('job_id');
                if (jobId) {
                    fetchFreelancerApplications(jobId);
                }
            } else {
                console.error(`Failed to accept application ${applicationId}.`);
                alert('Failed to accept application. Please try again.');
            }
        };
        xhr.onerror = function () {
            console.error('Error occurred during the request.');
            alert('Error occurred. Please try again.');
        };
        xhr.send();
    }
}

function rejectApplication(applicationId) {
    if (confirm('Are you sure you want to reject this application?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `../controller/updateApplicationStatus.php?application_id=${applicationId}&status=rejected`, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(`Application ${applicationId} rejected.`);
                // Refresh the applications list
                const urlParams = new URLSearchParams(window.location.search);
                const jobId = urlParams.get('job_id');
                if (jobId) {
                    fetchFreelancerApplications(jobId);
                }
            } else {
                console.error(`Failed to reject application ${applicationId}.`);
                alert('Failed to reject application. Please try again.');
            }
        };
        xhr.onerror = function () {
            console.error('Error occurred during the request.');
            alert('Error occurred. Please try again.');
        };
        xhr.send();
    }
}

function markAsCompleted(applicationId) {
    if (confirm('Are you sure you want to mark this work as completed? This will process the payment to the freelancer.')) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `../controller/updateApplicationStatus.php?application_id=${applicationId}&status=completed`, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(`Application ${applicationId} marked as completed.`);
                alert('Work marked as completed! Payment has been processed.');
                // Refresh the applications list instead of reloading the entire page
                const urlParams = new URLSearchParams(window.location.search);
                const jobId = urlParams.get('job_id');
                if (jobId) {
                    fetchFreelancerApplications(jobId);
                }
            } else {
                console.error(`Failed to mark application ${applicationId} as completed.`);
                alert('Failed to mark work as completed. Please try again.');
            }
        };
        xhr.onerror = function () {
            console.error('Error occurred during the request.');
            alert('Error occurred. Please try again.');
        };
        xhr.send();
    }
}



