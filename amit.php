<?php
/*
Template name: amit
*/

/*------------- Insert data with Ajax in DataBase----------------*/

get_header();

?>
<style>

#result_msg{
    padding-top: 25px;
}
#frmContactUs .false{
    color:red;
    font-weight: 600;
}

#frmContactUs .true{
    color:green;
    font-weight: 600;

}
</style>

<div id="form" style="border:1px solid black; display:inline-block; padding:1rem;">
    <form id="frmContactUs">

        <label>First Name </label>
        <input type="text" name="fname" required>
        <br><br>

        <label>Last Name</label>
        <input type="text" name="lname" required>
        <br><br>

        <label>Email </label>
        <input type="email" name="email" required>
        <br><br>

        <label>Password </label>
        <input type="password" name="password" required>
        <br><br>

        <label>City </label>
        <input type="text" name="city" required>
        <br><br>

        <label>Country </label>
        <input type="text" name="country" required>
        <br><br>

        <input type="submit" name="submit" value="Submit">
        <div id="result_msg"> </div>
        <!-- <button><a href='login.php'>Login</a></button> -->

    </form>
</div>

<script>
    jQuery("#frmContactUs").submit(function(){
        event.preventDefault();
        jQuery('#result_msg').html('')
        var link="<?php echo admin_url('admin-ajax.php')?>";
        // alert(link);
        var form=jQuery("#frmContactUs").serialize();
        var formData = new FormData;
        formData.append('action','con_us');
        formData.append('con_us',form);
        jQuery.ajax({
            url:link,
            data:formData,
            processData:false,
            contentType:false,
            type:'post',
            success:function(result){
                if(result.success == true){
                    jQuery("#frmContactUs")[0].reset();
                }
                jQuery('#result_msg').html('<span class="'+ result.success +'">'+ result.data +'</span>')
                // alert(result.data);
            }
        });
    });
</script>

/*-----------------------function.php----------------------*/
<?php
add_action('wp_ajax_con_us','ajax_con_us');
    function ajax_con_us(){
        $arr=[];
        wp_parse_str($_POST["con_us"],$arr);
        global $wpdb;
        global $table_prefix;
        $table=$table_prefix."con_us";

        $result= $wpdb->insert($table,[
            "firstname" => $arr['fname'],
            "lastname" => $arr['lname'],
            "email" => $arr['email'],
            "password" => $arr['password'],
            "city" => $arr['city'],
            "country" => $arr['country']
        ]);
        if($result > 0){
            wp_send_json_success("Data Inserted");
        }else{
            wp_send_json_error("Please Try Again");
        }
       
       
        // echo'<pre>';
        // print_r($arr);
        // wp_send_json_success('test');
    }

?>

<?php
get_footer();
?>
