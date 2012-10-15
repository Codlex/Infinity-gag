<?php 
include("../includes/initialize.php");

$title = "Welcome :: Infinity-gag";

include(TEMPLATE_DIR . DS . "header.php");
?>


<body>

	<?php include(TEMPLATE_DIR.DS.'headbar.php')?>
	<div id="container" style="">
		<div id="main">

			<div id="block-content">

				<div class="filter-bar ">
					<ul class="content-type">
						<li><a
						<?php if(!isset($_GET['most_popular'])){ echo " class=\"current\" ";} ?>
							href="index.php"><strong>Newest</strong> </a>
						</li>
						<li><a
						<?php if(isset($_GET['most_popular'])){ echo " class=\"current\" ";} ?>
							href="index.php?most_popular=jeste"><strong>Most popular</strong>
						</a>
						</li>
					</ul>
				</div>


				<div id="content" listpage="hot" data-page-key="hot">

					<div id="entry-list" class="list">
						<ul id="entry-list-ul" class="col-1">

							<?php
							$images = !isset($_GET['most_popular'])? Image::all_images_ordered_by_date() : Image::all_images_ordered_by_vote();

							?>


							<?php foreach($images as $image){?>
							<li class=" entry-item">

								<div class="content">
									<div class="img-wrap">
										<a href="image.php?id=<?php echo $image->id; ?>"
											target="_blank" class=""> <img
											src="images/<?php echo $image->filename; ?>"
											alt="<?php echo $image->title ?>" style="max-width: 460px;">
										</a>
									</div>
									<div class="fatbigdick all-users-expand"></div>

								</div> <!--end div.content-->

								<div class="info jump_stop jump_focus ">
									<div class="sticky-items  " id="sticky-item-4324602" style="">
										<h1>
											<a href="image.php?id=<?php echo $image->id; ?>"
												target="_blank" class=""><?php echo $image->title ?> </a>
										</h1>
										<h4 class="all-users-expand">
											<?php 
											$user = User::find_by_id($image->user_id);
											?>
											<a href="profile.php?id=<?php echo $user->id; ?>"
												target="_blank"><?php echo $user->username ?> </a>
											<p>
												<?php $image->print_time(); ?>
											</p>
										</h4>



									</div>

								</div> <!--end div.info-->
							</li>
							<?php }?>
						</ul>
					</div>
					<!--end entry-list-->








				</div>
				<!--end div#content-->
			</div>
			<!--end div#block-content-->
		</div>
		<!--end div#main-->
	</div>


	<?php include(TEMPLATE_DIR.DS.'sidebar.php'); ?>
</body>


</html>
