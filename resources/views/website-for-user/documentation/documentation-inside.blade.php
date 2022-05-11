@extends('website-for-user.partials-main.main')
@section('css')
    <!-- Pop Up -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">

    <link rel="stylesheet" href="/assets-user/css/style-documentation-inside.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"> </script>
@endsection

@section('main')
    <div class="container" style="margin-top:150px">
        <div class="row">
            <div class="col-12 top-dokumentasi">
                <h1 class="judul">DOKUMENTASI</h1>
            </div>

        <!-- Documentation Picture Starts Here -->
        <div class="zoom-gallery">
            <h1 class="jenis-kuliah-tamu">Kuliah Tamu - {{ $dokumentasi[0]->nama_event }}</h1>
            <div class="row">
                <!-- Picture 1 -->
                <div class="col-md-6 col-sm-12 col-6">
                    <a href="https://www.pradita.ac.id/assets/img/post/image/sport-court-pradita-university__rHK11.jpg" class="foto-kuliahtamu" data-source="https://www.pradita.ac.id/student-facilities" title="Kuliah Tamu 1" style="width:193px;height:125px;">
                        <img src="https://www.pradita.ac.id/assets/img/post/image/sport-court-pradita-university__rHK11.jpg" class="foto-dokumentasi">
                    </a>
                </div>
                <!-- End of Picture 1 -->

                <!-- Picture 2 -->
                <div class="col-md-6 col-sm-12 col-6">
                    <a href="https://www.pradita.ac.id/assets/front/images/new/univ-pradita-footer.jpg" class="foto-kuliahtamu" data-source="https://www.pradita.ac.id/student-facilities" title="Kuliah Tamu 1" style="width:82px;height:125px;">
                        <img src="https://www.pradita.ac.id/assets/front/images/new/univ-pradita-footer.jpg" class="foto-dokumentasi">
                    </a>
                </div>
            <!-- End of Picture 2 -->
            </div>
        </div>
        <!-- Documentation Picture Ends Here -->

        <!-- Download Button Starts Here -->
        <div class="row">
            <div class="col-md-6 col-sm-12 col-6">
                <form class="button-download">
                    <a href="/dokumentasi2/assets/praditaa.jpg" download class="btn btn-outline-warning" role="button" aria-pressed="true">Download Foto Dokumentasi 1</a>
                </form>
            </div>

            <div class="col-md-6 col-sm-12 col-6">
                <form class="button-download">
                    <a href="/dokumentasi2/assets/praditaa.jpg" download class="btn btn-outline-warning" role="button" aria-pressed="true">Download Foto Dokumentasi 2</a>
                </form>
            </div>

            <div class="col-md-12 col-sm-12">
                <form class="button-download">
                    <a href="/assets-user/pradita.mp4" download class="btn btn-outline-warning" role="button" aria-pressed="true">Download Video Dokumentasi</a>
                </form>
            </div>

            <div class="col-md-12 col-sm-12">
                <form class="button-back">
                    <a href="documentation.html" class="btn btn-outline-warning" class="back" role="button" aria-pressed="true">Back</a>
                </form>
            </div>
        </div>
        <!-- Download Button Ends Here -->
        </div>
    </div>
@endsection

@section('js')
    <script src ="/assets-user/js/script-magnetic-popup.js"></script>
    <script src ="/assets-user/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
@endsection
