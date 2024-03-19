const API_ERROR = 'https://pizza-24297-default-rtdb.firebaseio.com/logError.json'

var sendData = async(error) =>{
    let response = await fetch(API_ERROR, {
        method:"POST", 
        body:JSON.stringify(error)
    })
    if(!response.ok){
        return {error: "Erreur d'envoi du message d'erreur"}
    }
    let result = await response.json()
    return result
}
var sendErrorNotification = async (ev) =>{
    let date = (new Date()).toLocaleDateString()
    date += " "+(new Date()).toLocaleTimeString()

    let error = {
        navigator: navigator.userAgent,
        errorName: ev.error.name,
        errorMessage: ev.error.errorMessage,
        errorStack: ev.error.stack,
        urlPage: location.href,
        createdAt: date
    }

    var result = await sendData(error)
    
    console.log(result);
}
window.addEventListener('error', sendErrorNotification)
