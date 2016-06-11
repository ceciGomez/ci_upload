<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css'); ?>" />

    </head>
    <body>
        <input id="input-704" name="file[]" type="file" multiple=true class="file-loading">

        <script type="text/javascript" src="<?= base_url('assets/plugins/jquery/jquery2.min.js'); ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js'); ?>"></script>
        <script>
            $(function () {
                $("#input-704").fileinput({
                    uploadUrl: "<?= base_url('welcome/doUpload');?>", // server upload action
                    uploadAsync: false,
                    minFileCount: 1,
                    maxFileCount: 5,
                    initialPreviewAsData: true // identify if you are sending preview data only and not the markup
                });
            });
        </script>
    </body>
</html>

<!--<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php // echo $error;?>

<?php // echo form_open_multipart('welcome/do_upload');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>
    </body>
</html>-->
