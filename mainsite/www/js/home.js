var pos  = 0;
var secs = 5000;

function moveLastPosts(id)
{
	var div = document.getElementById(id);
	if (pos == 0) { resetLastPosts(id); }

	pos  = pos + 1;

	setTimeout("writePost('" + id + "')", secs);
	if (pos >= posts.length) {
		pos = 0;
	}
}

function writePost(id)
{
	var div   = document.getElementById(id);
	var texto = "";

	texto += "<a href=\"http://" + posts[pos][0] + ".lynksee.com\" style=\"vertical-align: middle;\"><img src=\"/img/ico_page.png\" alt=\"Web\" title=\"Web\" style=\"vertical-align: middle;\" border=\"0\"/></a>";
	texto += " ";
	texto += "<a href=\"http://" + posts[pos][0] + ".lynksee.com/blog/?feed=rss2\" style=\"vertical-align: middle;\"><img src=\"/img/ico_rss.png\" alt=\"Rss\" title=\"Rss\" style=\"vertical-align: middle;\" border=\"0\"/></a>";
	texto += " ";
	texto += "<a href=\""+ posts[pos][1] + "\" style=\"vertical-align: middle;\">" + posts[pos][3] + "</a><br/>";

	div.innerHTML = texto + div.innerHTML;
	moveLastPosts(id);
}

function resetLastPosts(id)
{
	var div   = document.getElementById(id);
	var texto = "";

	for (i = 0; i <= 16; i++)
	{
		texto += "<a href=\"http://" + posts[i][0] + ".lynksee.com\" style=\"vertical-align: middle;\"><img src=\"/img/ico_page.png\" alt=\"Web\" title=\"Web\" style=\"vertical-align: middle;\" border=\"0\"/></a>";
		texto += " ";
		texto += "<a href=\"http://" + posts[i][0] + ".lynksee.com/blog/?feed=rss2\" style=\"vertical-align: middle;\"><img src=\"/img/ico_rss.png\" alt=\"Rss\" title=\"Rss\" style=\"vertical-align: middle;\" border=\"0\"/></a>";
		texto += " ";
		texto += "<a href=\""+ posts[i][1] + "\" style=\"vertical-align: middle;\">" + posts[i][3] + "</a><br/>";
	}

	div.innerHTML = texto;
	pos = 16;
}