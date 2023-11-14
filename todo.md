# WAI 2: tokyo drift
> php BEZ FRAMEWORKÓW

> galeria z historią

> rejestracja, logowanie, wylogowanie

> znajomość architektury

> wzorzec MVC: `front controller, routing, kontrolery, moddel, widoki, logika biznesowa`

> *Dla chętnych*: obiektowa implementacja MVC

## KATEGORIA I: łatwe

1. [ ] przesyłanie plików na serwer
    - tylko pliki `.png`, `.jpg`
    - nie większe niż 1 MB
    - `DocumentRoot/images`

2. [ ] znak wodny i thumbnail
    - w formularzu *obowiązkowy* field `znak wodny`
    - otrzymany plik > nałożyć watermark > stworzyć miniaturę 200x125px
    - lib PHP GD (jest już w VMie)
    - 3 pliki per upload: origin, watermark, thumbnail

3. [ ] galeria zdjęć
    - prezentacja miniatur
    - paging po dowolną ilość zdjęć
    - na kliknięcie > pełny rozmiar
    > JEŻELI miniatury się nie udały, pagują się pomniejszone w CSSie oryginały
    - użyj dwóch: `include, include_once, require, require_once`

## KATEGORIA II: średnie
...