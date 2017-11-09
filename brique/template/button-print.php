<button onclick="window.print();"><?php
if ( isPage($page_refuse) || isPage($page_annule) ) {
  echo 'Imprimer le rapport';
} else {
  echo 'Imprimer le justificatif';
}
?></button>
