let getReportBy = {
    '': '',
    'Blood type distribution': ['City', 'Blood type', 'Age segment'],
    'Survey results and answers': [ /*'City', */ 'Question' /*, 'Age segment'*/ ],
    'Recoveries report': ['City', 'Hospital', 'Date', 'Age segment'],
    'Deaths report': ['City', 'Hospital', 'Date', 'Age segment'],
    'User vaccinating status': [ /*'City',*/ 'Vaccine status' /*, 'Age segment'*/ ],
    'User vaccinating status (summary)': ['Default'],
    'Distribution of hospitals': ['City', 'Hospital'],
    'Infections report': ['City', 'Vaccine status', 'Date', 'Age segment'],
    'Distribution of chronic diseases': ['Chronic disease' /*, 'Age segment'*/ ],
    'Distribution of doctors in hospitals': ['City', 'Hospital'],
    'Distribution of doctors in campaigns': ['City'],
    'Hospitalization status': ['City', 'Hospital', 'Date', 'Age segment'],
    'Hospital statistics': ['City', 'Hospital', 'Date'],
    'Hospital statistics (summary)': ['Default'],
    'Campaign report (summary)': ['Default'],
    'General statistics': ['Default'],
    'Vaccine report': ['Default'],
    'Personal medical report': ['Default'],
};
let report_by;

function reportBy(reportName) {
    report_by.innerHTML = '';
    let reportBy = getReportBy[reportName];
    for (let i = 0; i < reportBy.length; i++) {
        let option = document.createElement('option');
        option.value = reportBy[i];
        option.innerText = reportBy[i];
        report_by.appendChild(option);
    }
    report_by.style.display = 'block';
}


window.onload = function () {
    report_by = document.getElementById('report-by');
    report_by.style.display = 'none';
    let report_name = document.getElementById('report-name');
    report_name.addEventListener('change', event => {
        reportBy(event.target.value);
    });
}
