<?php
include "pdo.php";
if(isset($_POST['like']))
{
	include "like.php";
}
?>
<?php include('includes/head_section.php');
?>
<title>MyBlog | Posts</title>
</head>
<body>
<style>
.container img {
  float:left;
  max-width: 50px;
  width: 100%;
  margin-right: 20px;
  border-radius: 0%;
}
.btn-link:hover, .btn-link, .btn-link:focus{
  text-decoration: none;
}
.card-header{
       padding: 5px 5px;
   }

</style>
  <?php
  // Get images from the database
  $z=0;
  $stmt = $pdo->query("SELECT * FROM images natural join users ORDER BY uploaded_on DESC");
  if ( $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) )
  {
    ?>
    <div class="bs-example">
        <div class="accordion" id="accordionExample">
          <?php foreach($rows as $row)
  	{	$z=$z+1;
    	$imageURL = 'uploads/'.$row["file_name"];
      $profile_picURL='profile_pics/'.$row["profile_pic"];
    	if(substr($imageURL,-3)=="JPG"||substr($imageURL,-3)=="PNG"||substr($imageURL,-3)=="png"||substr($imageURL,-3)=="jpg"||substr($imageURL,-4)=="jpeg"||substr($imageURL,-4)=="JPEG")
    		{
    ?>

        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button type="button" class="btn btn-link w-100" data-toggle="collapse" data-target="#collapse<?php echo ($z) ?>" style="text-align:left;">
                    <div class="container">  <img src="<?php echo $profile_picURL;?>" alt="Profile Pic"/>
              <span style="font-size:20pt;"><?php echo(ucfirst($row['name']))?></span></div><span style="font-size:10pt;color:#808080;"><?php echo($row['uploaded_on'])?></span><center><span style="font-size:16pt;color:danger;"><?php echo($row['message'])?></span></center></button>

                </h2>
            </div>
            <div id="collapse<?php echo($z) ?>" class="collapse" aria-labelledby="collapse<?php echo($z) ?>" data-parent="#accordionExample">
                <div class="card-body h-100">
                  <figure>
                    <center>
                      <img src="<?php echo $imageURL;?>" alt="<?php echo $row["file_name"];?>" style="width:1100px;height:700px"/>
                    </center>
                  <figcaption>
                  <?php
                        $sql="select likes from images where post_id='".$row["post_id"]."'";
                        $stmt=$pdo->query($sql);
                        $l = $stmt->fetch(PDO::FETCH_ASSOC);
                        $s="select * from likes where post_id='".$row["post_id"]."' and name='".$_SESSION["name"]."'";
                        $stmt1=$pdo->query($s);
                        $p = $stmt1->fetch(PDO::FETCH_ASSOC);
                        if($p===FALSE){
                        echo('<form action="' . htmlentities($_SERVER["PHP_SELF"]) . '"'. 'method="POST"><input type="hidden" ');
                        echo('name="post_id" value="'.$row['post_id'].'">'."\n");
                        echo('&emsp;<button type="submit" class="btn btn-primary" name="like" value="like" style="font-color:blue;"><i class="fa fa-thumbs-o-up fa-lg">Like</i>&nbsp;'.$l["likes"].'</button>');
                        echo $row['post_id'];
                        $_SESSION['post_id']=$row['post_id'];
                        echo('</form>');
                        }
                        else {
                        echo('&emsp;<button type="submit" class="btn btn-primary" name="like" value="like" style="font-color:blue;"><i class="fa fa-thumbs-o-up fa-lg">Liked</i>&nbsp;'.$l["likes"].'</button>');
                        }

                        ?>
                        &emsp;<button type="submit" class="btn btn-primary" name="comment" value="comment" style="font-color:blue;"><i class="fa fa-comment-o fa-lg">Comment</i></button>'
                        <form action="/html/tags/html_form_tag_action.cfm" method="post">
<div>
<textarea name="comments" id="comments" style="font-family:sans-serif;font-size:1.2em;">
Hey... say something!
</textarea>
</div>
<input type="submit" value="Submit">
</form>


                  <center>
                    <?php if(!empty($row['message'])) {echo ($row['message']);}?>
                  </center>
                  </figcaption>
                  </figure>
                  </div>
            </div>
        </div>
      <?php }}} ?>
</div>
</div>

<?php include( ROOT_PATH . '/includes/footer.php'); ?>