<form id="restore-form" action="" method="post">
    <input type="hidden" name="action" value="restore">
</form>
<script>
    (function(doc) {
        "use strict";
        
        function restoreEntity(e) {
            e.preventDefault();
            var form = doc.getElementById("restore-form");
            form.action = WGTOTW.basePath + "admin/<?= $entity ?>/restore/" + e.target.getAttribute("data-id");
            form.submit();
        }
        
        Array.prototype.forEach.call(doc.getElementsByClassName("restore-link"), function(a) {
            a.addEventListener("click", restoreEntity);
        });
    })(document);
</script>
