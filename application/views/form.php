<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Simple upload</title>
    </head>
    <body>
        <?= $error;?>
        <?= form_open_multipart('simpleUpload/doUpload');?>
        <input type="file" name="userfile" size="20" />
        <br /><br />
        <input type="submit" value="upload" />

    </form>
</body>
</html>
