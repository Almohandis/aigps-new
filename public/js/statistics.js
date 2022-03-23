let getReportBy = {
    '': '',
    'Blood type distribution': ['City', 'Blood type', 'Age segment'],                                                 //1
    'Survey results and answers': [ /*'City', */ 'Question' /*, 'Age segment'*/ ],                                    //2
    'Recoveries report': ['City', 'Hospital', 'Date', 'Age segment'],                                                 //3
    'Deaths report': ['City', 'Hospital', 'Date', 'Age segment'],                                                     //4
    'User vaccinating status': [ 'City / age segment', 'Vaccine status' /*, 'Age segment'*/ ],                        //5
    'User vaccinating status (summary)': ['Default'],                                                                 //6
    'Distribution of hospitals': ['City', 'Hospital'],                                                                //7
    'Infections report': ['City', 'Vaccine status', 'Date', 'Age segment'],                                           //8
    'Distribution of chronic diseases': ['Chronic disease' /*, 'Age segment'*/ ],                                     //9
    'Distribution of doctors in hospitals': ['City', 'Hospital'],                                                     //10
    // 'Distribution of doctors in campaigns': ['City'],
    'Hospitalization status': ['City', 'Hospital', 'Date', 'Age segment'],                                            //11
    // 'Hospital statistics': ['City', 'Hospital', 'Date'],
    // 'Hospital statistics (summary)': ['Default'],
    'Campaign report': ['City', 'Campaign'],                                                                         //12
    'General statistics': ['Default'],                                                                                //13
    // 'Vaccine report': ['Default'],
    'Personal medical report': ['Default'],                                                                           //14
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
    report_by.style.display = 'inline-block';
}


window.onload = function () {
    report_by = document.getElementById('report-by');
    report_by.style.display = 'none';
    let report_name = document.getElementById('report-name');
    report_name.addEventListener('change', event => {
        reportBy(event.target.value);
    });
}
