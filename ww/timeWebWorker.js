function updateTime() {
    const currentTime = new Date();
    const formattedTime = currentTime.toLocaleTimeString();
    
    // Trimit timpul formatat inapoi catre threadul principal
    postMessage(formattedTime);

    // Programez functia sa ruleze din nou peste 1000ms(o secunda)
    setTimeout(updateTime, 1000);
}
updateTime();