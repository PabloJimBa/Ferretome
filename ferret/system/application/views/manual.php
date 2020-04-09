<?php if (!defined('BASEPATH')) exit('Wir haben Sie nicht verstanden!'); ?>
<?php  $this->load->view('header');  ?>

<?php if($action == 'index'):?>

	<h1>Manual</h1>

	<h2>How to insert new data?</h2>

	<ol>
		<li><a href="index.php?c=manual&m=literature_add">Add new literature</a></li>
		<li><a href="index.php?c=manual&m=author_add">Add new author</a></li>
		<li><a href="index.php?c=manual&m=journal_add">Add new journal/book</a></li>
		<li><a href="index.php?c=manual&m=acronym_add">Add new acronym</a></li>
		<li><a href="index.php?c=manual&m=brainmap_add">Add new brain map</a></li>
		<li><a href="index.php?c=manual&m=brainsite_add">Add new brain site</a></li>
		<li><a href="index.php?c=manual&m=architecture_add">Add new architecture to a brain site</a></li>
		<li><a href="index.php?c=manual&m=bmrelation_add">Add new relation of brain maps</a></li>
		<li><a href="index.php?c=manual&m=injectionmethod_add">Add new injection method</a></li>
		<li><a href="index.php?c=manual&m=injection_add">Add new injection</a></li>
		<li><a href="index.php?c=manual&m=injectiondata_add">Add new additional data for injection</a></li>
		<li><a href="index.php?c=manual&m=outcome_add">Add new labeling outcome</a></li>
		<li><a href="index.php?c=manual&m=labelledsite_add">Add new labelled site</a></li>
		<li><a href="index.php?c=manual&m=injectionoutcome_add">Add new relation of injections and outcomes</a></li>

<?php endif;?>

<?php if($action == 'literature_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>
	<h1>Add new literature</h1>

	<a target="_blank" href="index.php?c=literature&m=add">Open add page</a>

	<ol><strong>
		<li>Select publication authors</li></strong>

		* They should be in the same order as in the paper.<br>
		** If you cannot find any author, please <a target="_blank" href="index.php?c=manual&m=author_add">add it.</a><br>&nbsp;

		<strong><li>Select journal/book which the paper are in.</li></strong>

		* If you cannot find the journal/book, please <a target="_blank" href="index.php?c=manual&m=journal_add">add it.</a><br>&nbsp;

		<strong><li>Insert the publication title.</li><br>
		<li><strong>Insert the publication year.</li><br>
		<li>Insert the journal number or chapter number in which the publication is found.</li><br>
		<li>Insert the page number in which the publication is found.</li><br>
		<li>Insert the publication abstract.</li><br>
		<li>Insert the publication DOI ID.</li><br>
		<li>Insert the publication PubMed ID.</li><br>
		<li>Insert any comment.</li><br>
		<li>Upload the publicatio in pdf format.</li><br>
		<li>Press the insert button to add the new literature.</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=author_add">Next chapter</a>

<?php endif;?>

<?php if($action == 'author_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new author</h1>

	<a target="_blank" href="index.php?c=authors&m=add">Open add page</a>

	<ol><strong>
		<li>Insert author name.</li><br>
		<li>Insert author surname.</li><br>
		<li>Insert author middle name.</li><br>
		<li>Press the insert button to add the new author.</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=journal_add">Next chapter</a></p>

<?php endif;?>

<?php if($action == 'journal_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new journal/book</h1>

	<a target="_blank" href="index.php?c=abbreviations&m=add">Open add page</a>

	<ol><strong>
		<li>Insert abbreviation.</li><br>
		<li>Insert full name.</li><br>
		<li>Press the insert button to add the new acronym.</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=acronym_add">Next chapter</a></p>

<?php endif;?>

<?php if($action == 'acronym_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new acronym</h1>

	<a target="_blank" href="index.php?c=acronyms&m=add">Open add page</a>

	<ol><strong>
		<li>Insert abbreviation.</li><br>
		<li>Insert full name.</li><br>
		<li>Press the insert button to add the new acronym.</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=brainmap_add">Next chapter</a></p>

<?php endif;?>

<?php if($action == 'brainmap_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new brain map</h1>

	<a target="_blank" href="index.php?c=brainmaps&m=add">Open add page</a>

	<ol><strong>
		<li>Search for the publication in which this brain map is described.</li><br>
		<li>Choose the brain map type.</li></strong>

		* Click into the field "Delineated" if at least one brain site of the map is delineated.<br>
		  &nbsp;&nbsp;Click into the field "Adopted" if at least one brain site of the brain map is adopted in an ambiguous way.<br>&nbsp;

		<strong><li>Specify the number of the figures in which the brain map is described.</li></strong>

		* Example: 1,2-5 or 1,3,5<br>&nbsp;

		<strong><li>Specify the numbers of the pages in which the brain map is described.</li></strong>

		* Example: 1,2-5 or 1,3,7<br>&nbsp;

		<strong><li>Insert relevant citation.</li><br>
		<li>Insert any comment.</li><br>
		<li>Press the insert button to add the new acronym.</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=brainsite_add">Next chapter</a></p>

<?php endif;?>

<?php if($action == 'brainsite_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new brain site</h1>

	<a target="_blank" href="index.php?c=brainsites&m=add">Open add page</a>

	<ol><strong>
		<li>Search for the publication in which the brain map containing the brain site is decribed.</li><br>
		<li>Search for the brain site acronym.</li><br></strong>

		* If you cannot find the brain site, please <a target="_blank" href="index.php?c=acronyms&m=show">check the list.</a><br>&nbsp;

		<strong><li>Choose the brain map type.</li><br>
		<li>Press the insert button to add the new acronym.</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=architecture_add">Next chapter</a></p>

<?php endif;?>

<?php if($action == 'architecture_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new architecture of brain sites</h1>

	<a target="_blank" href="index.php?c=architecture&m=add">Open add page</a>

	<ol><strong>
		<li>Search for the publication in which the brain site is described.</li><br>
		<li>Search for the brain site.</li><br>
		<li>Choose between the whole brain site or a specific layer.</li><br>
		<li>Select the parameter to add.</li><br></strong>

		* If you cannot find any proper parameter, please <a target="_blank" href="index.php?c=manual&m=parameter_add">add it.</a><br>&nbsp;

		<strong><li>Insert a value.</li><br>
		<li>Choose the architecture PDC.</li><br>
		<li>Click on "Save parameter" to add the new parameter to the architecture of the brain site.</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=bmrelation_add">Next chapter</a></p>

<?php endif;?>

<?php if($action == 'bmrelation_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new maps relation</h1>

	<a target="_blank" href="index.php?c=mapsrelations&m=add">Open add page</a>

	<ol><strong>
		<li>Search for the publication in which the relation is described.</li><br>
		<li>Search for the publication in which the brain site A is described.</li><br>
		<li>Choose the type of relation between the brain sites.</li><br>
		<li>Search for the publication in which the brain site B is described.</li><br>
		<li>Choose the precision of description code (PDC) of the relation.</li><br>
		<li>Specify the numbers of the pages in which the brain map is described.</li></strong>

		* Example: 1,2-5 or 1,3,7<br>&nbsp;

		<strong><li>Specify the number of the figures in which the brain map is described.</li></strong>

		* Example: 1,2-5 or 1,3,5<br>&nbsp;

		<strong><li>Insert citation.</li><br>
		<li>Insert any comment.</li><br>
		<li>Press the insert button to add the new maps relation.</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=injectionmethod_add">Next chapter</a></p>

<?php endif;?>

<?php if($action == 'injectionmethod_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new injection method</h1>

	<a target="_blank" href="index.php?c=methods&m=add">Open add page</a>

	<ol><strong>
		<li>Search for the publication in which the injection method is described.</li><br>
		<li>Search for the tracer used in this method.</li><br></strong>

		* If you cannot find the tracer, please <a  target="_blank" href="index.php?c=tracers&m=show">check the list.</a><br>&nbsp;

		<strong><li>Mark the box if the tracer is used in both hemispheres.</li><br></strong>

		* Within the same animal – regardless whether the same or different brain structures were injected.		

		<strong><li>Specify the numbers of the pages in which the brain map is described.</li></strong>

		* Example: 1,2-5 or 1,3,7<br>&nbsp;

		<strong><li>Specify the number of the figures in which the brain map is described.</li></strong>

		* Example: 1,2-5 or 1,3,5<br>&nbsp;

		<strong><li>Insert the injection method.</li><br>
		<li>Insert the survial time (time between the injection and the death) - in hours or days.</li><br>
		<li>Insert the number of sections.</li><br>
		<li>Insert any comment.</li><br>
		<li>Press the insert button to add the new injection method.</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=injection_add">Next chapter</a></p>

<?php endif;?>

<?php if($action == 'injection_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new injection</h1>

	<a target="_blank" href="index.php?c=injections&m=add">Open add page</a>

	<ol><strong>
		<li>Search for the publication in which the injection and the method are described.</li><br>
		<li>Search for the method used in this injection.</li><br></strong>

		* If you cannot find the method, please <a  target="_blank" href="index.php?c=manual&m=injectionmethod_add">add it.</a><br>&nbsp;

		<strong><li>Search for the publication in which the brain map is described.</li><br>
		<li>Search for the brain site where the injection was given.</li><br>
		<li>Choose the precision of description code (PDC) of the label.</li><br>
		<li>Insert the description of the injetcion and any methodical problem.</li><br>
		<li>Specify the numbers of the pages in which the injection is described.</li></strong>

		* Example: 1,2-5 or 1,3,7<br>&nbsp;

		<strong><li>Specify the number of the figures in which the injection is described.</li></strong>

		* Example: 1,2-5 or 1,3,5<br>&nbsp;

		<strong><li>Specify the volume of injected tracer substance (in microliter, µl).</li></strong>

		* If it is unknown, enter a question mark (?)<br>&nbsp;		

		<strong><li>Specify the concentration of injected tracer substance (in percent, %).</li></strong>

		* If it is unknown, enter a question mark (?)<br>&nbsp;

		<strong><li>Choose the injection laminae.</li><br>
		<li>Choose the PDC laminae.</li><br>
		<li>Press the insert button to add the new injection method.</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=injectiondata_add">Next chapter</a></p>

<?php endif;?>

<?php if($action == 'injectiondata_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new injection data</h1>

	<a target="_blank" href="index.php?c=injectionsdata&m=add">Open add page</a>

	<ol><strong>
		<li>Search for the publication in which the injection is decribed.</li><br>
		<li>Choose the injection.</li><br>
		<li>Click on "Add new data".</li><br>
		<li>Choose the parameter to add.</li><br>
		<li>Insert the parameter value.</li><br>
		<li>Search for the publication in which the injection data is decribed if it is different from the above.</li><br>
		<li>Click on "Save data".</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=outcome_add">Next chapter</a></p>

<?php endif;?>

<?php if($action == 'outcome_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new labeling outcome</h1>

	<a target="_blank" href="index.php?c=labelingoutcome&m=add">Open add page</a>

	<ol><strong>
		<li>Search for the publication in which the labelling outcome is described.</li><br>
		<li>Click on "Add new outcome".</li><br>
		<li>Choose the outcome to add.</li><br>
		<li>Click on "Save".</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=labelledsite_add">Next chapter</a></p>

<?php endif;?>

<?php if($action == 'labelledsite_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new labelled site</h1>

	<a target="_blank" href="index.php?c=labelledsites&m=add">Open add page</a>

	<ol><strong>
		<li>Search for the publication in which the injection is described.</li><br>
		<li>Choose the labeling outcome.</li><br>
		<li>Search for the publication in which the brain map is described.</li><br>
		<li>Select the brain map.</li><br>
		<li>Choose the precision of description code (PDC) of the labelled site.</li><br>
		<li>Choose the extension code (EC) of the labelled site.</li><br>
		<li>Choose the density of the labelled site.</li><br>
		<li>Insert the number of neurons.</li><br>
		<li>Insert the percentage of labelled neurons.</li><br>
		<li>Choose the injection laminae.</li><br>
		<li>Choose the PDC laminae.</li><br>
		<li>Press the insert button to add the new injection method.</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=injectionoutcome_add">Next chapter</a></p>

<?php endif;?>

<?php if($action == 'injectionoutcome_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new relation between injections and outcomes</h1>

	<a target="_blank" href="index.php?c=injectionsoutcomes&m=add">Open add page</a>

	<ol><strong>
		<li>Search for the publication in which the relation is described.</li><br>
		<li>Choose the labeling outcome.</li><br>
		<li>Click on "Add injection to outcome".</li><br>
		<li>Choose the injection to add.</li><br>
		<li>Click on "Save".</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=index">Index</a></p>

<?php endif;?>

<?php if($action == 'parameter_add'):?>

	<p align="right"><a href="javascript:history.go(-1)">Back</a> &nbsp; | &nbsp; <a href="index.php?c=manual&m=index">Index</a></p>

	<h1>Add new architecture parameter</h1>

	<ol><strong>
		<li>Insert parameter name.</li><br>
		<li>Insert parameter description.</li><br>
		<li>Choose the parameter type.</li><br>
		<li>Press the insert button to add the new architecture parameter.</li>
	</ol></strong>

	<p><a href="index.php?c=manual&m=index">Index</a></p>

<?php endif;?>

<?php $this->load->view('footer'); ?>
