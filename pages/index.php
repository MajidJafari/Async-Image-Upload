<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ReactPHP App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <style>
        body { padding-top: 50px }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Uploads</h1>
        </div>
        <div class="col-sm-12">
            <form action="/upload"
                  method="post"
                  class="justify-content-center"
                  enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file">Submit a file:</label>
                    <input name="file"
                           id="file"
                           type="file"
                           accept="image/x-png,image/jpeg"
                    />
                </div>
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </form>
        </div>
        <div class="col-sm-12">
            <hr>
            <h3>Already uploaded:</h3>
                <?php $uploads = file('php://stdin'); ?>
                <?php if (empty($uploads)): ?>
                    No files.
                <?php else: ?>
                    <ul class="list-group col-sm-6">
                        <?php foreach ($uploads as $upload): ?>
                            <li class="list-group-item">
                                <a href="download/uploads/<?php echo $upload ?>">
                                    <img src="previews/<?php echo $upload ?>">
                                    <?php echo $upload ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>