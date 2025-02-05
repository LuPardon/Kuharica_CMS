<?php
/* Template Name: O Nama */
?>

<?php get_header(); ?>

<!-- Header sa slikom -->
<div class="container-fluid p-0">
    <div class="header-image position-relative">
        <img src="https://www.malinca.si/media/clnews/16962371601639415799.webp"
            class="img-fluid w-100"
            alt="Kuharica - Blog o Receptima">
        <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center">

            <div class="text-center mb-4">
                <h1 class="text-white text-center fw-bold display-4">
                    Dobrodošli na Kuharicu!
                </h1>
                <p class="text-white lead text-center w-50 mx-auto fw-bolder">
                    Kuharica je vaš vodič kroz svijet kulinarstva! Naša misija je dijeliti ukusne recepte, savjete za kuhanje i inspiraciju za svaki obrok. Bez obzira jeste li početnik ili iskusni kuhar, ovdje ćete pronaći nešto za sebe.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Sadržaj stranice "O nama" -->
<div class="container my-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="text-center">
                <p class="lead fw-semibold">
                    Kuharica je više od bloga o hrani - to je zajednica strastvenih kuhara i gurmana. Na našoj stranici možete istražiti raznolike recepte, od klasičnih jela do modernih interpretacija, kao i otkriti nove začine, tehnike i ideje za kuhanje.
                </p>
                <img src="https://nebraskastarbeef.com/wp-content/uploads/2022/09/52913995_m-scaled.jpg"
                    class="img-fluid rounded mb-4"
                    alt="Delicious Recipes">
            </div>
            <p class="fw-semibold">
                Naš tim pažljivo odabire recepte kako bi svaki obrok bio poseban. Bilo da tražite brzo i jednostavno jelo za užurbane dane ili želite impresionirati goste nečim sofisticiranim, Kuharica je pravo mjesto za vas.
            </p>
            <div class="text-center mt-4">
                <a href="<?php echo get_post_type_archive_link('recepti'); ?>" class="btn btn-primary btn-lg">
                    Pogledajte naše recepte
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php get_footer(); ?>