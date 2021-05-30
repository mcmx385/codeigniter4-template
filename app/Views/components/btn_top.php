<!-- Go to top -->
<button onclick="topFunction()" id="btnTop" title="Go to top">▲</button>

<style>
    #btnTop {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Fixed/sticky position */
        bottom: 20px;
        /* Place the button at the bottom of the page */
        right: 20px;
        /* Place the button 30px from the right */
        z-index: 99;
        /* Make sure it does not overlap */
        border: none;
        /* Remove borders */
        outline: none;
        /* Remove outline */
        background-color: white;
        /* Set a background color */
        color: blue;
        /* Text color */
        cursor: pointer;
        /* Add a mouse pointer on hover */
        padding: 8px 12px 8px 12px;
        /* Some padding */
        border-radius: 5px;
        /* Rounded corners */
        font-size: 18px;
        /* Increase font size */
        box-shadow: .5px .5px 3px #888888;
    }

    #btnTop:hover {
        background-color: blue;
        /* Add a dark-grey background on hover */
        color: white;
        /* Text color */
    }
</style>

<script>
    //Get the button:
    mybutton = document.getElementById("btnTop");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }
</script>