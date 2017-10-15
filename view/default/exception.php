<h2>Ofångat undantag i Anax</h2>
<dl>
    <dt>Typ:</dt>
    <dd><code><?= get_class($e) ?></code></dd><br>
    <dt>Meddelande:</dt>
    <dd><?= $e->getMessage() ?></dd><br>
    <dt>Kod:</dt>
    <dd><?= $e->getCode() ?></dd><br>
    <dt>Fil:</dt>
    <dd><i><?= $e->getFile() ?></i></dd><br>
    <dt>Rad:</dt>
    <dd><?= $e->getLine() ?></dd>
</dl>
<h3>Stackhistorik</h3>
<pre><code><?= $e->getTraceAsString() ?></code></pre>
