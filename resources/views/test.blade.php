<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    Hello
    <br>
    <input type="button" id="btn" value="Export">
    <input type="hidden" name="text" id="txt">

    <table class="table table-hover" style="margin: 10px 50px; width:350px">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City</th>
                <th>Country</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>kjdf</td>
                <td>kjdf</td>
                <td>kjdf</td>
                <td>kjdf</td>
                <td>kjdf</td>
            </tr>
        </tbody>
    </table>
    <script>
        let btn = document.getElementById('btn');
        btn.addEventListener('click', function() {

            let table = document.querySelector('table');
            let html = table.outerHTML;
            console.log(html);
            var opt = {
                margin: 0.25,
                filename: 'myfile.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.99
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            };

            html2pdf().from(html).set(opt).save();
            // let txt = document.getElementById('txt');
            // txt.value = html;
            // document.querySelector('form').submit();
            // make ajax request to your server
            // let xhr = new XMLHttpRequest();
            // xhr.open('POST', '/employee/pdf', true);
            // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            // xhr.onload = function() {
            //     document.write(xhr.responseText);
            // };
            // xhr.send('html=' + html);

            // let blob = new Blob([html], {
            //     type: "application/vnd.ms-excel;charset=charset=utf-8"
            // });
            // let url = URL.createObjectURL(blob);
            // let a = document.createElement('a');
            // a.href = url;
            // a.download = 'test.xls';
            // a.click();
        });
    </script>
</body>

</html>
