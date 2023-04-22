// let productCardPrice = document.querySelector("#cardapius-card-valor-produto"); 


// if(!productCardPrice.innerHTML.includes(".")){
//     productCardPrice.innerHTML = productCardPrice.innerHTML + ".00"
// } else {
//     console.log("tem ponto")
// }




// var inputGroup = document.querySelectorAll('.cardapius-input-group');

// inputGroup.forEach(function(group) {
//     var btnMinus = group.querySelector('.cardapius-btn-minus');
//     var btnPlus = group.querySelector('.cardapius-btn-plus');
//     var inputNumber = group.querySelector('.cardapius-input-number');
//     btnMinus.addEventListener('click', function() {
//         var currentValue = parseInt(inputNumber.value);
//         if (currentValue > 0) {
//             inputNumber.value = currentValue - 1;
//         }
//     });
    
//     btnPlus.addEventListener('click', function() {
//         var currentValue = parseInt(inputNumber.value);
//         if (currentValue < parseInt(inputNumber.max)) {
//             inputNumber.value = currentValue + 1;
//         }
//     });
// });



// document.body.addEventListener(evento, function(event) {

//   });


//   if (event.target.classList.contains('button-1')) {
//     // função para o botão 1
//     console.log('Botão 1 clicado');
//   } else if (event.target.classList.contains('button-2')) {
//     // função para o botão 2
//     console.log('Botão 2 clicado');
//   } else if (event.target.classList.contains('button-3')) {
//     // função para o botão 3
//     console.log('Botão 3 clicado');
//   } else if (event.target.classList.contains('button-4')) {
//     // função para o botão 4
//     console.log('Botão 4 clicado');
//   } else if (event.target.classList.contains('button-5')) {
//     // função para o botão 5
//     console.log('Botão 5 clicado');
//   }



function eventos(event, verifica, execucao) {
    document.body.addEventListener(event, function(obj) {
      // Verifica se o alvo do evento tem a classe desejada
      if (obj.target.classList.contains(verifica) || obj.target.id.indexOf(verifica) !== -1) {
        execucao(obj.target);
      }
    });
 }

function exibirAdicional(elemento){
    let adicionaisLoop = this.nextElementSibling;
    if(elemento.classList.contains("cardapius-card-produto") & adicionaisLoop.classList.contains("cardapius-adicionais-loop")){
        adicionaisLoop.classList.remove('cardapius-adicionais-loop-hidden');
    }
};

eventos("click", "cardapius-card-produto", exibirAdicional)




let cardProdutos = document.querySelectorAll('.cardapius-card-produto');
cardProdutos.forEach(cardProduto => {
  cardProduto.addEventListener('click', () => {
    let adicionaisLoop = cardProduto.nextElementSibling;
    if(adicionaisLoop.classList.contains("cardapius-adicionais-loop")){
      adicionaisLoop.classList.remove('cardapius-adicionais-loop-hidden');
    }
  });
});


const popup = document.querySelector('.popup');
const closeBtn = document.querySelector('.close-btn');

closeBtn.addEventListener('click', function() {
  popup.style.display = 'none';
});



const closeButtonsPopup = document.querySelectorAll('.cardapius-button-close');
closeButtonsPopup.forEach((button) => {
  button.addEventListener('click', () => {
    const popup = button.closest('.cardapius-popup');
    popup.classList.add('cardapius-adicionais-loop-hidden');
  });
});


let valorProduto = document.querySelectorAll(".cardapius-product-value, .cardapius-valor-produto-span")
console.log(valorProdutoPost);
valorProduto.forEach((valor) =>{
  let valorAtual = valor.innerHTML
  if(valorAtual.indexOf(".") >= 0){
    valorAtual = valorAtual.replace(/\./g, ",")
    valor.innerHTML = valorAtual
  } else {
    valor.innerHTML += ",00"
  }
});



let cardapiusLabelCep = document.querySelector('.myd-cart__checkout-label[for="input-delivery-zipcode"]');
cardapiusLabelCep.innerHTML = "CEP"

