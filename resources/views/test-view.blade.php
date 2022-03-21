<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" id="upload-image" action="/test-add">
            @csrf
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <input type="file" name="image" placeholder="Choose image" id="image">
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                </div>
            </div>
        </form>

    </div>
</body>

</html>
