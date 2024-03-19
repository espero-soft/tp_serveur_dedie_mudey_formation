
var theme = document.querySelector('.theme-color input')

if(typeof(localStorage) !== "undefined"){
    let color = localStorage.getItem('themeColor')
    if(color){
        document.documentElement.style.setProperty('--main-color', color)
    }
}


theme.onchange = (event)=>{
    let color = event.target.value;
    if(typeof(localStorage) !== "undefined"){
        localStorage.setItem("themeColor",color)
    }
    document.documentElement.style.setProperty('--main-color', color)
}
