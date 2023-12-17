<?php require_once("templates/template-head.html") ?>  
<body>
    <header class="full-width">
        <div class="flex-container" style="justify-content: space-between;">
            <h1 id="page">Forum</h1>
        </div>
    </header>
    <div class="flex-container" id="main-flex-container">
        <?php require_once("templates/template-nav.html") ?>

        <article>
            <p>
                Witaj na naszym forum poświęconym ulubionym grą komputerowym! To miejsce, gdzie każdy z nas może podzielić się swoją pasją do gier, wymienić doświadczeniami i zainspirować innych do odkrywania nowych tytułów. Gdy wkraczamy w świat gier komputerowych, zanurzamy się w niesamowitych historiach, wyzwaniach i przygodach, które często zostają z nami na długo.
            </p>
            <p>
                Na tym forum chcemy stworzyć przestrzeń, w której możemy dzielić się naszymi ulubionymi grami, opisywać, dlaczego są dla nas wyjątkowe, i polecać je innym pasjonatom. Niezależnie od tego, czy jesteś zapalonym graczem czy dopiero zaczynasz swoją przygodę z grami, to miejsce jest dla Ciebie. Tutaj znajdziesz inspirację, nowe pomysły na gry do wypróbowania i możliwość wymiany poglądów na temat swoich ulubionych tytułów.
            </p>
            <p>
                Odkryj razem z nami różnorodność gier komputerowych, które kształtują naszą pasję i emocje. Może Twoja ulubiona gra jest klasykiem z przeszłości, nowym hitem czy mało znanym dziełem, które zasługuje na więcej uwagi. Dzięki temu forum, możemy razem odkrywać, czym tak wyjątkowe są gry komputerowe i dlaczego kochamy je tak bardzo. Zostań częścią naszej społeczności i podziel się swoją miłością do gier!
            </p>
        </article>
        <!-- for HiH -->
        <!-- <form id="form" method="post" action="/forum">
            <h2>Dodaj własną grę!</h2>
            <label for="nick">Nick:</label><br>
            <input type="text" name="nick" id="nick"><br>

            <label for="email">E-mail:</label><br>
            <input type="email" name="email" id="email"><br>
            
            <label for="name">Tytuł gry:</label><br>
            <input type="text" name="title" id="name"><br>
            
            <h3>Kategoria:</h3>
            <input type="checkbox" name="cat-shooter" id="cat-shooter">
            <label for="cat-shooter">strzelanka</label><br>
            <input type="checkbox" name="cat-management" id="cat-management">
            <label for="cat-management">zarządzanie</label><br>
            <br>

            <label for="rating">Twoja ocena:</label>
            <input type="number" min="1" max="10" name="rating" id="rating"><br>
            
            <h3>Platforma:</h3>
            <input type="radio" name="platform" id="platform-steam">
            <label for="platform-steam">Steam</label><br>
            <input type="radio" name="platform" id="platform-epic">
            <label for="platform-epic">Epic Games</label><br>

            <h3>Recenzja</h3>
            <textarea name="review"></textarea><br>
        
            <input type="submit" value="Wyślij" id="submit-button"> <input type="button" value="Wyczyść" id="clear-button">
        </form> -->
        <form id="form" method="POST" action="/forum" enctype="multipart/form-data">
            <label for="username">Username</label><br>
            <input type="text" name="username" id="username-input"/><br>

            <label for="watermark">Watermark</label><br>
            <input type="text" name="watermark" id="watermark-input"/><br>

            <label for="screenshot">Screenshot</label><br>
            <input type="file" name="screenshot" id="screenshot-input"/><br>

            <input type="submit" value="Wyślij" id="submit-button">
            <input type="button" value="Wyczyść" id="clear-button">
        </form>
    </div>
    <?php require_once("templates/template-footer.html") ?>
</body>
</html>