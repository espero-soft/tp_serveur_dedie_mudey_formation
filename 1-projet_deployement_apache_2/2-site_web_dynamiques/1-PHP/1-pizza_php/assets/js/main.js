'use strict'
//Requête vers serveur local
//var request = location.origin+'/api/pizza.json'

//Requête vers serveur distant
// var request = "https://pizza-24297-default-rtdb.firebaseio.com/pizza.json"
var request = "/assets/api/pizza.json"




var getHeritages = (obj) =>{
    var prototype = Object.getPrototypeOf(obj)
    var result = []
    while (prototype) {
        result[result.length] = prototype.constructor.name 
        prototype = Object.getPrototypeOf(prototype)

    }
    return result
}

var getNumber = (nb) =>{
    if(typeof(nb) !== "number"){
        throw new Error("La fonction attend un nombre")
    }
    return nb
}


try {
    console.log(getNumber("2"));
    
} catch (error) {
    console.log('Error :',error.message);
}

var getPizzaData = async () =>{
    let response = await fetch(request)
    let pizzas = await response.json()
    return pizzas
}
var create = (element, content, className="") =>{
    const elt = document.createElement(element)
    elt.innerHTML = content 
    elt.className = className
    return elt
}
var displayModal = (product) =>{
    var modalContainer = create('div',"", "modal-container")
    var modal = document.createElement('div')
    var modalHeader = document.createElement('div')
    var modalContent = document.createElement('div')
    var modalImage = document.createElement('div')
    var modalDescription = document.createElement('div')
    var close = document.createElement('i')
    var overlay = document.createElement('div')
    var title = document.createElement('h2')
    overlay.className = "overlay fixed"
    close.className= "bi bi-x-lg absolute"
    modal.className = "modal fixed box relative"
    modalContent.className = "modal-content flex gap-10"
    modalHeader.className = "modal-header"
    modalHeader.appendChild(close)
    modalImage.className = "modal-image flex-2"
    modalDescription.className = "modal-description flex-3 b p-10"
    modalImage.style.backgroundImage = `url('${product.image}')`
    modalImage.style.backgroundPositionX = 60+"%"

    
    modalContent.appendChild(modalImage)
    modalContent.appendChild(modalDescription)

    modal.appendChild(modalHeader)
    modal.appendChild(modalContent)

    title.innerText = product.name
    
    modalDescription.appendChild(title)
    const p = create("p", product.description)
    const optionsTitle = create("h3", "Options")
    var options = document.createElement('ul')
    options.className = "options"

    product.options.forEach(option =>{
        // <li class="flex gap-15">
        //     <div class="option-name">Sauce</div>
        //     <div class="divider flex-1"></div>
        //     <div class="option-price">12.99 €</div>
        // </li>
        var item = document.createElement('li')
        var optionName = create("div",option.name, "option-name")
        var optionDivider = create("div","", "divider flex-1")
        var optionPrice = create("div", parseFloat(option.additonnalPrice, 2).toFixed(2)+" €", "option-price")
        var item = create('li', "", "flex gap-15")
        item.appendChild(optionName)
        item.appendChild(optionDivider)
        item.appendChild(optionPrice)

        options.appendChild(item)

    })

    const button = create("button", "Acheter", "flex-1")

    modalDescription.appendChild(p)
    modalDescription.appendChild(optionsTitle)
    modalDescription.appendChild(options)
    modalDescription.appendChild(button)

    //end
    modalContainer.appendChild(overlay)
    modalContainer.appendChild(modal)

    document.body.appendChild(modalContainer)

    close.onclick = () =>{
        document.body.removeChild(modalContainer)
        document.body.style.overflow =""
    }
    overlay.onclick = () =>{
        document.body.removeChild(modalContainer)
        document.body.style.overflow =""
    }

{/* <div class="modal-container">
        <div class="overlay fixed"></div>
        <div class="modal fixed box relative">
          <div class="modal-header ">
            <i class="bi bi-x-lg absolute"></i>
          </div>
          <div class="modal-content flex gap-10">
            <div class="modal-image flex-2 b" style="background-image: url('/assets/images/pizza/4-fromages.jpg')" >
            </div>
            <div class="modal-description flex-3 b p-10">
                <h2>4 Fromages</h2>
                <p>
                Sauce tomate à l'origan ou crème fraîche légère, mozzarella, fromage de chèvre, emmental et Fourme d'Ambert AOP
                </p>
                <h3>Options</h3>
                <ul class="options">
                    <li class="flex gap-15">
                        <div class="option-name">Sauce</div>
                        <div class="divider flex-1"></div>
                        <div class="option-price">12.99 €</div>
                    </li>
                    <li class="flex gap-15">
                        <div class="option-name">Sauce</div>
                        <div class="divider flex-1"></div>
                        <div class="option-price">12.99 €</div>
                    </li>
                    <li class="flex gap-15">
                        <div class="option-name">Sauce</div>
                        <div class="divider flex-1"></div>
                        <div class="option-price">12.99 €</div>
                    </li>
                    <li class="flex gap-15">
                        <div class="option-name">Sauce</div>
                        <div class="divider flex-1"></div>
                        <div class="option-price">12.99 €</div>
                    </li>
                    <li class="flex gap-15">
                        <div class="option-name">Sauce</div>
                        <div class="divider flex-1"></div>
                        <div class="option-price">12.99 €</div>
                    </li>
                    <li class="flex gap-15">
                        <div class="option-name">Sauce</div>
                        <div class="divider flex-1"></div>
                        <div class="option-price">12.99 €</div>
                    </li>
                    <li class="flex gap-15">
                        <div class="option-name">Sauce</div>
                        <div class="divider flex-1"></div>
                        <div class="option-price">12.99 €</div>
                    </li>
                    <li class="flex gap-15">
                        <div class="option-name">Sauce</div>
                        <div class="divider flex-1"></div>
                        <div class="option-price">12.99 €</div>
                    </li>
                    <li class="flex gap-15">
                        <div class="option-name">Sauce</div>
                        <div class="divider flex-1"></div>
                        <div class="option-price">12.99 €</div>
                    </li>
                    <li class="flex gap-15">
                        <div class="option-name">Sauce</div>
                        <div class="divider flex-1"></div>
                        <div class="option-price">12.99 €</div>
                    </li>
                </ul>
                <button class="flex-1">
                  Payer
                </button>
            </div>
          </div>
        </div>
</div> */}
}

var useData = async ()=>{
    var data = await getPizzaData()
    data = Object.values(data)
    // var app = document.getElementById('app')
    // app ? app.innerHTML = "" : null 

    
    // data.forEach(product => {
    //     var productItem = `
    //             <div class="product-item relative" data-id="${product._id}">
    //                 <img src="${product.image}" width="150" alt="">
    //                 <div class="product-details">
    //                     <div class="product-name">${product.name}</div>
    //                     <div class="add-to-cart absolute">
    //                         <i class="bi bi-zoom-in"></i> Détails
    //                     </div>
    //                     <div class="product-price">
    //                         <span class="sold-price">${product.soldPrice/100}</span>
    //                         <span class="regular-price"><del>${product.price/100}</del></span>
    //                     </div>
    //                 </div>
    //             </div>
    //     `
    //     app.innerHTML += productItem
    //    // console.log(productItem);
    // });

    document.querySelectorAll(".product-item").forEach((item)=>{
        item.addEventListener("click", ()=>{
            const _id = item.dataset.id
            const product = data.filter(p => p._id == _id)[0]
            console.log(product);
            displayModal(product)
            document.body.style.overflow ="hidden"

        })
    })
}

useData()

