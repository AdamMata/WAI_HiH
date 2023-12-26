<?php require_once("templates/template-head.html") ?>  
<body>
    <header class="full-width">
        <div class="flex-container" style="justify-content: space-between;">
            <h1 id="page">Forum</h1>
        </div>
    </header>
    <div class="flex-container" id="main-flex-container">
        <?php require_once("templates/template-nav.html") ?>
        <div>
            <article>
                <p>
                    Witaj na naszym forum poświęconym ulubionym grą komputerowym! To miejsce, gdzie każdy z nas może podzielić się swoją pasją do gier, wymienić doświadczeniami i zainspirować innych do odkrywania nowych tytułów. Gdy wkraczamy w świat gier komputerowych, zanurzamy się w niesamowitych historiach, wyzwaniach i przygodach, które często zostają z nami na długo.
                </p>
            </article>
            <div id="gallery">
                <?php foreach ($gallery as $entry):?>
                    <ul class="gallery-entry">
                        <li>
                            <a href="../images/watermarks/<?=$entry['name']?>" target="_blank">
                                <img src="../images/thumbnails/<?=$entry['name']?>" />
                            </a>
                        </li>
                        <li>Autor: <?=$entry['meta']['author']?></li>
                        <li>Tytuł: <?=$entry['meta']['title']?></li>
                        <li>
                            <label for="fav">Ulubione</label>
                            <input 
                                type="checkbox" 
                                <?php $name = str_replace(['_', '.', '-'], ['%und', '%per', '%dsh'], $entry['name']); //FIXME ?>
                                name="<?=$name?>"
                                <?php if (isset($fav) && $fav[$entry['name']] === 'on'): ?>
                                    checked=""
                                <?php endif ?>
                                class="fav-box" 
                                form="fav-form"
                            >
                        </li>
                    </ul>
                <?php endforeach ?>
                <form id="fav-form" name="fav-form" method="POST" action="/forum">
                    <input type="hidden" name="form" value="fav">
                    <input type="submit" value="Zapisz ulubione">
                </form>
            </div>
            <?php
                $cur = $model['page'];
                $min = 1; $max = $model['max'];
                if ($cur > $min) $prev = $cur - 1;
                if ($cur < $max) $next = $cur + 1;
            ?>
            <?php if(isset($prev)): ?>
                <a href="/forum?page=<?=$prev?>"><?=$prev?></a>
            <?php endif ?>
            <?=$cur?>
            <?php if(isset($next)): ?>
                <a href="/forum?page=<?=$next?>"><?=$next?></a>
            <?php endif ?>
        </div>     
        <div id="form-bar">
            <form id="form" method="POST" action="/forum" enctype="multipart/form-data">
                <input type="hidden" name="form" value="upload">

                <label for="username">Autor</label><br>
                <input type="text" required name="username" id="username-input"/><br>

                <label for="title">Tytuł</label><br>
                <input type="text" name="title" id="title-input"/><br>

                <label for="watermark">Znak wodny</label><br>
                <input type="text" required name="watermark" id="watermark-input"/><br>

                <label for="screenshot">Zdjęcie</label><br>
                <input type="file" name="screenshot" id="screenshot-input"/><br>

                <input type="submit" value="Wyślij" id="submit-button">
                <input type="button" value="Wyczyść" id="clear-button">
            </form>
            <span id="validation">
                <?= $validation ?>
            </span>
        </div>
    </div>
    <?php require_once("templates/template-footer.html") ?>
</body>
</html>