let seconds = 0;

function countSeconds() {
  seconds++;
  postMessage(seconds); // Trimit numaratoarea curenta catre threadul principal
  setTimeout(countSeconds, 1000); // Se repeta functia in fiecare secunda
}

countSeconds();