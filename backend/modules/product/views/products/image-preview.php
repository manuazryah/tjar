
<style>
    /*	.imgss {
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    padding: 5px;
                    width: 150px;
                    padding: 5px;

            }
            .imgss img {
                    max-width: 100%;
                    max-height: 100%;
                    -webkit-transition: .2s all;
                    position: relative;
            }

            .imgss img:hover {
                    -webkit-filter: brightness(50%);
            }
            .imgss:hover input {
                    display: block;
            }
            .imgss input {
                    position:absolute;
                    display:none;
            }
            .imgss input.update {
                    top:0;
                    left:0;
            }*/

    div.show-image {
        position: relative;
        float:left;
        margin:5px;
    }
    div.show-image:hover img{
        opacity:0.5;
    }
    div.show-image:hover a {
        display: block;
    }
    div.show-image a {
        position:absolute;
        display:none;
    }
    div.show-image span.profile_image {
        position: absolute;
        width: 53%;
        top: 0;
        background: #007eff;
        text-align: center;
        color: white;
    }
    div.show-image a.update {
        top:0;
        left:0;
    }
    div.show-image a.btn {
        padding: 1px 7px;
    }
    div.show-image a.btn i {
        font-size: 10px;
    }
    div.show-image a.delete_image {
        top: 4px;
        left: 80%;
    }




</style>
<style>
    /* The container */
    .radio_btn {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .radio_btn input {
        position: absolute;
        opacity: 0;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .radio_btn:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .radio_btn input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .radio_btn input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .radio_btn .checkmark:after {
        top: 9px;
        left: 9px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }
</style>


<?php
$path = $base_path;
if (count(glob("{$path}/*")) > 0) {

    $k = 0;
    $id = 0;
    foreach (glob("{$path}/*") as $file) {
        if (!is_dir($file)) {
            $arry = explode('/', $file);
            ?>
            <div class="show-image" id="<?= $k ?>">
                <div style="min-height: 165px;">
                    <img srcset="<?= $home_path . '/' . end($arry) ?>" alt="no-image" img-name="<?= end($arry) ?>"style="width:150px;height: 150px" id="image_<?= $id ?>">

                    <a class="update delete_image btn btn-icon btn-red"  id-for="<?= end($arry) ?>" id="delete_id_<?= $id ?>" href="" hide_delete="<?= $id ?>"><i class="fa-remove"></i>
                    </a>
                </div>
                <label class="radio_btn">
                    <input type="radio" name="profile-image" id="radio-btn-<?= $id ?>"  id-for="<?= $id ?>" value="profile-image<?= $id ?>" <?= $id == 0 ? 'checked' : '' ?> class="setProfile cbr cbr-red" >
                    <span class="checkmark"></span>
                </label>


            </div>

            <?php
        }
        ?>


        <?php
        $id++;
        $k++;
    }
}
?>
<script>
    $(document).ready(function () {
        var radio_btn = $('input[name="profile-image"]:checked').attr("id-for");
        $('#delete_id_' + radio_btn).hide();
        $('input[name=profile-image]').mouseup(function () {
            var previous = $('input[name=profile-image]:checked').attr("id-for");
            $('#delete_id_' + previous).show();
        }).change(function () {
            var current = $('input[name=profile-image]:checked').attr("id-for");
            $('#delete_id_' + current).hide();
        });
        $("input[name='profile-image']").change(function () {
            var id = $(this).attr("id-for");
            var img_path = $('#image_' + id).attr("img-name");
            $.ajax({
                url: '<?= Yii::$app->homeUrl; ?>product/products/set-profile-image', // Upload Script
                data: {imagepath: img_path},
                type: 'post',
                success: function (data) {
                    alert("set as profile image");
                },
                error: function (data) {
                }
            });
        });

        $('.delete_image').click(function (event) {
            event.preventDefault();
            var image = $(this).attr("id-for");
            var id = $(this).attr("id");

            if (confirm('Are you sure you want to delete this?')) {
                $.ajax({
                    url: '<?= Yii::$app->homeUrl; ?>product/products/delete-gallery-image-frm-temp', // Upload Script
                    data: {image: image, id: id},
                    type: 'post',
                    success: function (data) {
                        var $data = JSON.parse(data);
                        if ($data.msg == "success") {
                            $('#' + $data.div_id).hide();
                        } else {
                            alert($data.title);
                        }
                    },
                    error: function (data) {
                        alert(data);
                    }
                });
            }
        });
    });
</script>




