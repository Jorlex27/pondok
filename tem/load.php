<style>
    .absolute {
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 1000;
    }
</style>
<div class="relative h-screen" id="loader">
    <div class="rounded-md h-12 w-12 border-4 border-t-4 border-blue-500 animate-spin absolute"></div>
</div>

<script>
var loader = document.getElementById("loader");
window.addEventListener("load", function(){
    loader.style.display = "none";
})
</script>