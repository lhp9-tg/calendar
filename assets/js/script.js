console.log("Hello World!")

const modal = document.querySelector(".modal")
const trigger = document.querySelectorAll(".items")
const closeButton = document.querySelector(".close-button")

console.log(trigger)

function toggleModal() {
modal.classList.toggle("show-modal")
}

function windowOnClick(event) {
    if (event.target === modal) {
        toggleModal()
    }
}


trigger.forEach(element => {
    if (element.dataset.title !== '') {
        element.addEventListener("click", toggleModal)
        element.addEventListener("click", function() {
            if (element.dataset.title !== undefined) {
            const modaltitle = element.dataset.title
            document.querySelector(".modaltitle").innerHTML = modaltitle
            }
            if (element.children[1].dataset.desc !== undefined) {
            const modaldesc = element.children[1].dataset.desc
            document.querySelector(".modaldesc").innerHTML = modaldesc
            }
        })
    }
    
});

closeButton.addEventListener("click", toggleModal)
window.addEventListener("click", windowOnClick)