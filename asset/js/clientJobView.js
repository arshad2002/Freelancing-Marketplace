//Showdetails:
const urlParams = new URLSearchParams(window.location.search);
const job_id = urlParams.get('job_id');
const xhr = new XMLHttpRequest();
xhr.open('POST', '../controller/clientJobView.php', true);

xhr.onload = function() {
    if (xhr.status === 200) {
        const response = xhr.responseText;
        const jobDiv = document.getElementById('job'); 
        const jobDetails = JSON.parse(response)[0];
        
        let html = '<h3 style="color: var(--accent-primary); margin-bottom: 1.5rem;">Job Details</h3>';
        html += '<div style="background: transparent; color: var(--text-primary);">';
        html += '<p style="color: var(--text-primary); margin: 1rem 0; display: flex; justify-content: space-between;"><strong style="color: var(--accent-primary);">Title:</strong> <span style="color: var(--text-primary);">' + jobDetails.title + '</span></p>';
        html += '<p style="color: var(--text-primary); margin: 1rem 0; display: flex; justify-content: space-between;"><strong style="color: var(--accent-primary);">Description:</strong> <span style="color: var(--text-primary);">' + jobDetails.description + '</span></p>';
        html += '<p style="color: var(--text-primary); margin: 1rem 0; display: flex; justify-content: space-between;"><strong style="color: var(--accent-primary);">Job Type:</strong> <span style="color: var(--text-primary);">' + jobDetails.job_type + '</span></p>';
        html += '<p style="color: var(--text-primary); margin: 1rem 0; display: flex; justify-content: space-between;"><strong style="color: var(--accent-primary);">Payment:</strong> <span style="color: var(--text-primary);">$' + jobDetails.payment + '</span></p>';
        html += '<p style="color: var(--text-primary); margin: 1rem 0; display: flex; justify-content: space-between;"><strong style="color: var(--accent-primary);">Status:</strong> <span style="color: var(--text-primary);">' + jobDetails.status + '</span></p>';
        html += '<p style="color: var(--text-primary); margin: 1rem 0; display: flex; justify-content: space-between;"><strong style="color: var(--accent-primary);">Post Date:</strong> <span style="color: var(--text-primary);">' + jobDetails.post_date + '</span></p>';
        
        // Show applications info
        if (jobDetails.total_applications > 0) {
            html += '<p style="color: var(--text-primary); margin: 1rem 0; display: flex; justify-content: space-between;"><strong style="color: var(--accent-primary);">Applications:</strong> <span style="color: var(--text-primary);">' + jobDetails.total_applications + '</span></p>';
        }
        
        html += '</div>';
        html += '<div class="job-buttons" style="margin-top: 1.5rem; display: flex; gap: 1rem;">';
        
        // Conditional Edit button
        if (jobDetails.has_accepted_applications) {
            html += '<button disabled class="btn-disabled" style="background: #6b7280; cursor: not-allowed;" title="Cannot edit: Job has accepted applications or work in progress">Edit (Disabled)</button>';
        } else {
            let editButtonClass = '';
            let editTitle = '';
            
            if (jobDetails.has_pending_applications) {
                editButtonClass = 'btn-warning';
                editTitle = 'Warning: Job has pending applications';
            }
            
            html += '<button onclick="editJob(' + job_id + ')" class="edit-btn ' + editButtonClass + '" title="' + editTitle + '">EDIT</button>';
        }
        
        html += '<button onclick="deleteJob(' + job_id + ')" class="delete-btn">DELETE</button>';
        html += '</div>';
        
        jobDiv.innerHTML = html;
    }
};

const formData = new FormData();
formData.append('job_id', job_id);
xhr.send(formData);

//funcations:
function deleteJob(jobId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../controller/clientJobsDelete.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function () {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            console.log(data);
            if (data.success) {
                console.log(data);
                
                alert('Job deleted successfully');
                window.location.href = '../view/clientDashboard.php';
            } else {
                alert('Error deleting job');
            }
        } else {
            console.error('An error occurred:', xhr.statusText);
            alert('An error occurred while deleting the job');
        }
    };
    const requestData = {
        jobId: jobId
    };
    const jsonData = JSON.stringify(requestData);
    xhr.send(jsonData);
}

function editJob(jobId) {
    // Redirect to the edit job page
    window.location.href = '../view/jobEdit.php?job_id=' + jobId;
}



