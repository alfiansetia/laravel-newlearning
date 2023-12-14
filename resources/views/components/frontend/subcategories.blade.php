<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                @foreach ($subcategories as $item)
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="{{ $item->image }}">
                            <h5><a href="#">{{ $item->name }}</a></h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->
