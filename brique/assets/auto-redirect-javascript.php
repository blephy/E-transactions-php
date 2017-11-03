<script>
window.onload=function(){
  var auto = setTimeout(function(){ autoRefresh(); }, 100);

  function submitform(){
    document.forms[0].submit();
  }

  function autoRefresh(){
    clearTimeout(auto);
    auto = setTimeout(function(){ submitform(); autoRefresh(); }, <?php echo $redirect_time ?>);
  }
}
</script>
