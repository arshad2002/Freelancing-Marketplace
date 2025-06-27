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
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `../controller/appliedFreelance.php?job_id=${jobId}`, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);

            if (data.length > 0) {
                displayApplications(data);
            } else {
                console.log('No applications found for this job.');
            }
        } else {
            console.error('Error fetching applications:', xhr.statusText);
        }
    };

    xhr.send();
}

function displayApplications(applications) {
    const applicationListContainer = document.getElementById('applicationList');
    applicationListContainer.innerHTML = '';

    applications.forEach(function (application) {
        const listItem = document.createElement('li');
        listItem.innerHTML = `
                <p><strong>Freelancer:</strong> ${application.freelancer_name}<br> 
                <strong>Email:</strong> ${application.freelancer_email} <br> 
                <strong>Application:</strong> ${application.application_text}<br> </p>
                <button onclick="acceptApplication(${application.application_id})">Accept</button>
                <button onclick="rejectApplication(${application.application_id})">Reject</button>
            <hr>
        `;
        applicationListContainer.appendChild(listItem);
    });
}


function acceptApplication(applicationId) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `../controller/updateApplicationStatus.php?application_id=${applicationId}&status=accepted`, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(`Application ${applicationId} accepted.`);
        } else {
            console.error(`Failed to accept application ${applicationId}.`);
        }
    };
    xhr.onerror = function () {
        console.error('Error occurred during the request.');
    };
    xhr.send();
}

function rejectApplication(applicationId) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `../controller/updateApplicationStatus.php?application_id=${applicationId}&status=rejected`, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(`Application ${applicationId} rejected.`);
        } else {
            console.error(`Failed to reject application ${applicationId}.`);
        }
    };
    xhr.onerror = function () {
        console.error('Error occurred during the request.');
    };

    xhr.send();
}



