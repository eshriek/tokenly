<?php
if($isAll){
	$board = array('name' => 'Recent Posts', 'description' => '', 'slug' => 'all');
}
?>
<h1><?= $board['name'] ?></h1>
<?php
if(trim($board['description']) != ''){
	echo '<div class="board-description">'.$board['description'].'</div>';
}
?>
<?php
if(!$isAll AND $user AND $perms['canPostTopic']){
	echo '<div class="board-controls">
			<ul>
				<li><a href="'.SITE_URL.'/'.$app['url'].'/'.$module['url'].'/'.$board['slug'].'/post">Post New Topic</a></li>
			</ul>
		  </div>';
	
}

if($isAll){
?>
<p>
	<a href="#" class="filter-change">Filter Boards [+]</a>
</p>
<div id="board-filter" style="display: none;">
	<p>
		Choose what boards to show by default.
	</p>
	<label>Boards:</label>
	<form action="" method="post">
	<div class="Slick_UI_CheckboxList checkboxList">
		<?php
	
			$model = new Slick_Core_Model;
			$getfCats = $model->getAll('forum_categories', array('siteId' => $site['siteId']), array(), 'rank', 'asc');
			foreach($getfCats as $fcat){
				$getfBoards = $model->getAll('forum_boards', array('categoryId' => $fcat['categoryId'], 'active' => 1), array(), 'rank', 'asc');
				if(count($getfBoards) > 0){
					echo '<div class="clear"></div><h4>'.$fcat['name'].'</h4>';
					foreach($getfBoards as $fboard){
						$checked = 'checked';
						if(isset($boardFilters) AND count($boardFilters) > 0 AND !in_array($fboard['boardId'], $boardFilters)){
							$checked = '';
						}
						echo '<input type="checkbox" id="b-'.$fboard['boardId'].'" name="boardFilters[]" '.$checked.' value="'.$fboard['boardId'].'" />';
						echo '<label for="b-'.$fboard['boardId'].'">'.$fboard['name'].'</label>';
					}
				}
			}
		?>
		</div>
		<input type="submit" value="Save" />
	</form>	
</div>

<?php
}//endif
?>
<div class="board-topics">
	<?php
	
	if(count($stickies) > 0 AND (!isset($_GET['page']) OR $_GET['page'] == 1)){
		$stickyText = 'Hide';
		$stickyClass = 'collapse';
		$stickyDivStyle = '';
		if($isAll){
			$stickyText = 'Show';
			$stickyClass = '';
			$stickyDivStyle = 'display: none;';
		}
	?>
	<div class="clear"></div>
	<a href="#" class="sticky-trigger <?= $stickyClass ?>"><?= $stickyText ?> Sticky Posts</a>
	<div id="sticky-posts" style="<?= $stickyDivStyle ?>">
		<h4>Sticky Posts</h4>
	<?php
		$table = $this->generateTable($stickies, array('fields' => array('link' => 'Discussion', 'started' => 'Created',
																	   'numReplies' => 'Replies', 'views' => 'Views', 'lastPost' => 'Most Recent'),
													'class' => 'topics-table mobile-table'));
		
		echo $table->display();
	?>
	</div>
	<?php
	}
	
	if(count($topics) == 0){
		echo '<p>No discussions found</p>';
	}
	else{

		
		$table = $this->generateTable($topics, array('fields' => array('link' => 'Discussion', 'started' => 'Created',
																	   'numReplies' => 'Replies', 'views' => 'Views', 'lastPost' => 'Most Recent'),
													'class' => 'topics-table mobile-table'));
		
		echo $table->display();
		
		if($numPages > 1){
			echo '<div class="board-paging paging">
					<strong>Pages:</strong>';
			for($i = 1; $i <= $numPages; $i++){
				$active = '';
				if((isset($_GET['page']) AND $_GET['page'] == $i) OR (!isset($_GET['page']) AND $i == 1)){
					$active = 'active';
				}
				echo '<a href="'.SITE_URL.'/'.$app['url'].'/'.$module['url'].'/'.$board['slug'].'?page='.$i.'" class="'.$active.'">'.$i.'</a> ';
			}
			echo '</div>';
		}
	}
	?>
	
	
</div>
<?php
if($isAll){
?>
<hr>
<a name="stats"></a>
<h3>Statistics</h3>
<?php
$onlineList = array();
foreach($onlineUsers as $oUser){
	$onlineList[] = $oUser['link'];
}
?>
<ul class="forum-stats">
	<li><strong>Total Posts:</strong> <?= $numTopics + $numReplies ?> <em>(<?= $numTopics ?> discussions, <?= $numReplies ?> replies)</em></li>
	<li><strong>Total Users:</strong> <?= $numUsers ?></li>
	<li><strong>Most Ever Online:</strong> <?= $mostOnline ?></li>
	<li><strong>Currently Online (<?= $numOnline ?>):</strong> <?= join(', ', $onlineList) ?></li>
	
</ul>
<?php
	
}
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('.sticky-trigger').click(function(e){
			e.preventDefault();
			if($(this).hasClass('collapse')){
				$('#sticky-posts').slideUp();
				$(this).removeClass('collapse');
				$(this).html('Show Sticky Posts');
			}
			else{
				$('#sticky-posts').slideDown();
				$(this).addClass('collapse');
				$(this).html('Hide Sticky Posts');
			}
		});
		
		$('.filter-change').click(function(e){
			e.preventDefault();
			if($(this).hasClass('collapse')){
				$('#board-filter').slideUp();
				$(this).removeClass('collapse');
				$(this).html('Filter Boards [+]');
			}
			else{
				$('#board-filter').slideDown();
				$(this).addClass('collapse');
				$(this).html('Filter Boards [-]');
			}
			
		});
		
	});
</script>

