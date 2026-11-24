<script src="https://unpkg.com/zdog@1/dist/zdog.dist.min.js"></script>
<script src="<?= base_url('assets/frontend/js/main.js') ?>"></script>
<script>
function copyShareLink(btn) {
  var url = window.location.href;
  var done = function() {
    btn.classList.add('copied');
    setTimeout(function() { btn.classList.remove('copied'); }, 1500);
  };
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(url).then(done);
  } else {
    var ta = document.createElement('textarea');
    ta.value = url;
    ta.style.position = 'fixed';
    ta.style.opacity = '0';
    document.body.appendChild(ta);
    ta.select();
    document.execCommand('copy');
    document.body.removeChild(ta);
    done();
  }
}
</script>
</body>
</html>
