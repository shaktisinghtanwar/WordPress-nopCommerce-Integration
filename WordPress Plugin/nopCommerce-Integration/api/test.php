<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

$.getJSON('http://wordpress.trainingncr.info/wp-content/plugins/plugin/api/getajaxdata.php', function( data ) {
console.log(data);
});
});
</script>