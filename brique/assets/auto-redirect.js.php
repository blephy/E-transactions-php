<script>
window.onload=function(){
  var auto = setTimeout(function(){ autoRefresh(); }, 100);

  function submitform(){
    document.getElementById('form').submit();
  }

  function autoRefresh(){
    clearTimeout(auto);
    auto = setTimeout(function(){ submitform(); autoRefresh(); }, <?php echo $redirect_time ?>);
  }
}
</script>
