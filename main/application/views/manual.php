<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>

<?php if($action == 'main'):?>

	<h2>How to use the Ferretome database?</h2>

	<p>Read user manual <a href="index.php?c=manual&m=index">online</a> &nbsp; | &nbsp; Download user manual (<a href="User_manual.pdf" download>pdf</a>)</p>

<?php endif;?>

<?php if($action == 'index'):?>


	<h1>User manual</h1>

	<h2>Index</h2>

	<nav>
				<ul>
					<li><a href="index.php?c=manual&m=home">Home</a>
					
					<li><a href="index.php?c=manual&m=news">News</a>
	 				<div>
	 					<ul>
							<li><a href="index.php?c=manual&m=news_add">Add news</a></li>
							<li><a href="index.php?c=manual&m=news_delete">Delete news</a></li>
						</ul>
					</div>
	 				</li>
					<li><a href="index.php?c=manual&m=lit">Literature</a>
					<div>
	 					<ul>
							<li><a href="index.php?c=manual&m=lit_details">Literature details</a></li>
							<li><a href="index.php?c=manual&m=lit_map">Mapping data</a></li>
							<li><a href="index.php?c=manual&m=lit_exp">Experimental data</a></li>
							<div>
								<ul>
									<li><a href="index.php?c=manual&m=lit_exp_injection">Injection data</a></li>
									<li><a href="index.php?c=manual&m=lit_exp_site">Site of injection</a></li>
									<li><a href="index.php?c=manual&m=lit_exp_outcome">Injection outcome</a></li>
									<li><a href="index.php?c=manual&m=lit_exp_method">Injection method</a></li>
								</ul>
							</div>
							<li><a href="index.php?c=manual&m=lit_relation">Maps relation data</a></li>
						</ul>
					</div>
					<li><a href="index.php?c=manual&m=connectivity">Connectivity</a>
					<div>
	 					<ul>
							<li><a href="index.php?c=manual&m=connectivity_ferret">Ferret brain</a></li>
							<li><a href="index.php?c=manual&m=connectivity_cat">Cat connectivity mapped into ferret brain</a></li>
						</ul>
					</div>
					<li><a href="index.php?c=manual&m=contacts">Contacts</a>
					<li><a href="index.php?c=manual&m=admin">Admin</a>
					<li><a href="index.php?c=manual&m=login">Login</a>
				</ul>
		</nav>

<?php endif;?>

<?php if($action == 'home'):?>

<h3 align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></h3>

<h1>Home</h1>

<h3><strong>From home page you can access to the rest of pages. Just click on any options from the right upper menu.</strong></h3>

<img src="images/manual1.jpg" style="border:1px solid">

<h3><strong>In this page you will find a description of the Ferretome project...</strong></h3>

<img src="images/manual2.jpg" style="border:1px solid">

<h3><strong>... and a resume with the latest news on the right side.</strong></h3>

<img src="images/manual3.jpg" style="border:1px solid">

<br><br>

<h3><a href="index.php?c=manual&m=news">Next chapter</a></h3>

<?php endif;?>

<?php if($action == 'news'):?>

<h3 align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></h3>

<h1>News</h1>

<h3><strong>All news is displayed on this page. You will find the titles and the description texts below.</strong></h3>

<img src="images/manual4.jpg" style="border:1px solid">

<h3><strong>The “Show all” and “Add news” buttons can be used only for authorized users.</strong></h3>

<h3><strong>A resume with the latest news is also display on the right side.</strong></h3>

<img src="images/manual5.jpg" style="border:1px solid">

<br><br>

<ul>
	<li><h3><a target="_blank" href="index.php?c=manual&m=news_add">Add news</a></h3></li>
	<li><h3><a target="_blank" href="index.php?c=manual&m=news_delete">Delete news</a></h3></li>
</ul>

<br>

<h3><a href="index.php?c=manual&m=lit">Next chapter</a></h3>

<?php endif;?>

<?php if($action == 'news_add'):?>

<h1>Add news</h1>

<h3><strong>To add news, the title and its description must be introduced in their corresponding blanks.</strong></h3>

<img src="images/manual6.jpg" style="border:1px solid">

<h3><strong>After that, select “posted” type and click on “Insert”. If you want to save it as a draft, select “draft” type.</strong></h3>

<img src="images/manual7.jpg" style="border:1px solid">

<h3><strong>You also can upload files to your news.</strong></h3>

<img src="images/manual8.jpg" style="border:1px solid">

<?php endif;?>

<?php if($action == 'news_delete'):?>

<h1>Delete news</h1>

<h3><strong>Same steps as for adding news but selecting “deleted” type.</strong></h3>

<img src="images/manual9.jpg" style="border:1px solid">

<?php endif;?>


<?php if($action == 'lit'):?>

<h3 align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></h3>

<h1>Literature</h1>

<h3><strong>A search box, which has two options, is showed up in this page. The first option, the selected one, is searching literature by title. The second option es searching by authors</strong></h3>

<img src="images/manual10.jpg" style="border:1px solid">

<h3><strong>If we search any literature, the results will be shown in the below table.</strong></h3>

<ul>
	<li><strong>Authors:</strong> all author of the literature, in the same order as in the paper; can be selected to show all literature of a specific author</li>
	<li><strong>Title:</strong> of the literature; can be ordered alphabetically</li>
	<li><strong>Year:</strong> of the literature; can be ordered numerically</li>
	<li><strong>Source:</strong> of the literature; can be ordered alphabetically</li>
	<li><strong>Actions:</strong> “details” → show all literature data</li>
</ul>

<img src="images/manual11.jpg" style="border:1px solid">

<h3><strong>If “details” button is clicked on, a new page will be shown. Four tabs are available:</strong></h3>

<ul>
	<li><h3><a target="_blank" href="index.php?c=manual&m=lit_details">Literature details</a></h3></li>
	<li><h3><a target="_blank" href="index.php?c=manual&m=lit_map">Mapping data</a></h3></li>
	<li><h3><a target="_blank" href="index.php?c=manual&m=lit_exp">Experimental data</a></h3></li>
	<li><h3><a target="_blank" href="index.php?c=manual&m=lit_relation">Maps relation data</a></h3></li>
</ul>

<br>

<h3><a href="index.php?c=manual&m=connectivity">Next chapter</a></h3>

<?php endif;?>


<?php if($action == 'lit_details'):?>

<h1>Literature details</h1>

<h3><strong>A literature data resume (authors, title, year, source, abstract...).</strong></h3>

<img src="images/manual12.jpg" style="border:1px solid">

<?php endif;?>


<?php if($action == 'lit_map'):?>

<h1>Mapping data</h1>

<h3><strong>A mapping data resume of the brain map is shown in the first table.</strong></h3>

<img src="images/manual13.jpg" style="border:1px solid">

<h3><strong>And the table below shows all the brain sites localized in this brain map.</strong></h3>

<img src="images/manual14.jpg" style="border:1px solid">

<?php endif;?>


<?php if($action == 'lit_exp'):?>

<h1>Experimental data</h1>

<h3><strong>All injections are shown in the following table. Each injection data is divided in four categories, which you must click on to read their content:</strong></h3>

<img src="images/manual15.jpg" style="border:1px solid">

<ul>
	<li><h3><a target="_blank" href="index.php?c=manual&m=lit_exp_injection">Injection data</a></h3></li>
	<li><h3><a target="_blank" href="index.php?c=manual&m=lit_exp_site">Site of injection</a></h3></li>
	<li><h3><a target="_blank" href="index.php?c=manual&m=lit_exp_outcome">Injection outcome</a></h3></li>
	<li><h3><a target="_blank" href="index.php?c=manual&m=lit_exp_method">Injection method</a></h3></li>
</ul>

<?php endif;?>


<?php if($action == 'lit_exp_injection'):?>

<h1>Injection data</h1>

<h3><strong>An injection data resume (citation, injection hemisphere, injection volume...).</strong></h3>

<img src="images/manual16.jpg" style="border:1px solid">

<?php endif;?>


<?php if($action == 'lit_exp_site'):?>

<h1>Site of injection</h1>

<h3><strong>The name and abbreviation of the site of injection.</strong></h3>

<img src="images/manual17.jpg" style="border:1px solid">

<?php endif;?>


<?php if($action == 'lit_exp_outcome'):?>

<h1>Injection outcome</h1>

<h3><strong>A table with all injection outcomes data.</strong></h3>

<img src="images/manual18.jpg" style="border:1px solid">

<?php endif;?>


<?php if($action == 'lit_exp_method'):?>

<h1>Injection method</h1>

<h3><strong>A description about the injection method used.</strong></h3>

<img src="images/manual19.jpg" style="border:1px solid">

<?php endif;?>


<?php if($action == 'lit_relation'):?>

<h1>Maps relation data</h1>

<h3><strong>A table with all maps relations.</strong></h3>

<img src="images/manual20.jpg" style="border:1px solid">

<?php endif;?>


<?php if($action == 'connectivity'):?>

<h3 align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></h3>

<h1>Connectivity</h1>

<h3><strong>Two options are shown in this page: ferret brain (ferret connectivity data) and cat connectivity mapped into ferret brain (import cat connectivity data into a ferret brain).</strong></h3>

<img src="images/manual21.jpg" style="border:1px solid">

<ul>
	<li><h3><a target="_blank" href="index.php?c=manual&m=connectivity_ferret">Ferret brain</a></h3></li>
	<li><h3><a target="_blank" href="index.php?c=manual&m=connectivity_cat">Cat connectivity mapped into ferret brain</a></h3></li>
</ul>

<br>

<h3><a href="index.php?c=manual&m=contacts">Next chapter</a></h3>

<?php endif;?>


<?php if($action == 'connectivity_ferret'):?>

<h1>Ferret brain</h1>

<h3><strong>A matrix with all connectivity between injection outcomes.</strong></h3>

<img src="images/manual22.jpg" style="border:1px solid">

<?php endif;?>


<?php if($action == 'connectivity_cat'):?>

<h1>Cat connectivity mapped into ferret brain</h1>

<h3><strong>Not available yet. It will allow you to import all data from cat connectivity into a ferret brain.</strong></h3>

<?php endif;?>


<?php if($action == 'contacts'):?>

<h3 align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></h3>

<h1>Contacts</h1>

<h3><strong>Contact information.</strong></h3>

<img src="images/manual23.jpg" style="border:1px solid">

<br><br>

<h3><a href="index.php?c=manual&m=admin">Next chapter</a></h3>

<?php endif;?>


<?php if($action == 'admin'):?>

<h3 align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></h3>

<h1>Admin</h1>

<h3><strong>Page only available for authorized users. From this page, you will able to add/edit all pages, even the news which are shown in the news page.</strong></h3>

<img src="images/manual24.jpg" style="border:1px solid">

<h3><strong>If you click on “Show all pages”, a table with all the current pages is shown. You can preview or edit them.</strong></h3>

<img src="images/manual25.jpg" style="border:1px solid">

<h3><strong>If you click on “Create new page”, you will have to insert the page name, its content and the type of it (private or public). Private pages are only available to be seen by authorized users.</strong></h3>

<img src="images/manual26.jpg" style="border:1px solid">

<h3><strong>If you click on any options about news, please check the news section (above).</strong></h3>

<br>

<h3><a href="index.php?c=manual&m=login">Next chapter</a></h3>

<?php endif;?>


<?php if($action == 'login'):?>

<h3 align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></h3>

<h1>Login</h1>

<h3><strong>In case you are an authorized user, introduce your email and password.</strong></h3>

<img src="images/manual27.jpg" style="border:1px solid">

<?php endif;?>


<?php $this->load->view('footer'); ?>
