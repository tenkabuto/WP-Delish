<div class="wrap">
	<h2>Relevant Delicious Bookmarks</h2>

<form name="DelishBkmrks" action="<?php echo $action_url ?>" method="post">
<input type="hidden" name="submitted" value="1" /> 
<?php wp_nonce_field('delish-nonce'); ?>

<h3>Essentials</h3>
   <table class="form-table">
   		<tr>
			<th scope="row" valign="top">Title</th>
			<td>
				<textarea name="title"  rows="1" cols="40"><?php echo $title ?></textarea>
				<br />
				The default title is Recently Saved Bookmarks Tagged &#8220;<code>#activetag#</code>&#8221;. On the Tag page, the code <code>#activetag#</code> is automatically replaced with the active tag.
			</td>
   		</tr>
   		<tr>
			<th scope="row" valign="top">Delicious Username</th>
			<td>
				<input type="text" name="username"  value="<?php echo $username ?>" />
			</td>
   		</tr>
   		<tr>
			<th scope="row" valign="top">Bookmark Quantity</th>
			<td>
				<input type="text" name="quantity" value="<?php echo $quantity ?>" maxlength="2" />
				<br />
				How many bookmarks would you like to display? (There is a maximum of 50)
			</td>
   		</tr>
   	</table>
   	
<h3>Options</h3>
   	<table class="form-table">
   		<tr>
			<th scope="row" valign="top">Link to Tag</th>
			<td>
				<input type="checkbox" name="taglink" <?php echo $taglink ?> />
				<label for="disqus_comment_count">Link to Tag</label>
				<br />If checked, the active tag will link to your Delicious account's search page for the active link.
			</td>
   		</tr>
   		<tr>
			<th scope="row" valign="top">Notes</th>
			<td>
				<input type="checkbox" name="notes"  <?php echo $notes ?> />
				<label for="disqus_comment_count">Include Notes</label>
				<br />Would you like to include the Notes (descriptions) underneath the bookmarks?
			</td>
   		</tr>
   </table>
   <div class="submit"><input type="submit" name="Submit" value="Update" /></div>
   </form>
</div>