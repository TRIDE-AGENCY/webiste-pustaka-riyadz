<template>

    <Head>
        <title>{{ pageTitle }}</title>
    </Head>

    <LayoutUser :setting="setting">
        <section class="bg-animated-dots bg-white pt-20 position-relative border-bottom border-gray-300">
            <div class="dot-base"></div>
            <div class="dot-light-sweep"></div>
            <div class="dot-fade-mask"></div>
            <div class="container mw-1100px mx-auto position-relative z-index-1">
                <div class="mt-20 d-flex flex-column align-items-center text-center">
                    <h1 class="text-dark fs-4x fs-sm-3tx fs-md-4qx fs-xl-4tx fw-bolder mb-8">
                        {{ heroHeading }}
                    </h1>
                    <p class="text-gray-600 fs-3 fs-md-2 fw-semibold mb-14 mw-800px mw-xl-900px lh-lg">
                        {{ heroSubheading }}
                    </p>
                    <div class="d-flex flex-wrap flex-center gap-5 mb-16">
                        <a href="/books" style="width: 180px;"
                            class="btn btn-lg justify-content-center btn-myprimary-filled d-flex align-items-center gap-1 rounded-3 fs-5">
                            <i class="ri-book-read-fill fw-normal ms-n1 fs-3 text-myprimary"></i>
                            <span class="fw-bolder">Lihat Koleksi</span>
                        </a>
                        <a href="#" style="width: 180px;"
                            class="btn btn-lg btn-myprimary-tinted rounded-3 fs-5 fw-bolder">
                            Konsultasi Gratis
                        </a>
                    </div>
                    <img :src="heroImage" :alt="heroHeading"
                        class="w-550px w-sm-100 w-sm-850px w-md-100 mt-5 mt-md-15"
                        @error="setFallbackImage($event, 'hero')">
                </div>
            </div>
        </section>

        <section class="container w-100 mw-1100px mx-auto mt-20 pt-20">
            <div class="d-flex flex-column w-100 mt-20">
                <h2 class="text-center text-dark lh-sm fw-bolder fs-2tx mb-6 mw-550px mx-auto">
                    Alur Terstruktur
                </h2>
                <p class="text-center text-gray-600 fw-semibold lh-lg fs-3 mb-14 mw-650px mx-auto">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, facere modi ab non fugit, sit sequi
                    corrupti nesciunt officiis.
                </p>
                <div class="row g-6 justify-content-center">
                    <div v-for="step in processSteps" :key="step.id" class="col-12 col-sm-6 col-md-4">
                        <div class="text-center h-100 rounded-4 p-8 transition-all bg-white border border-gray-300 duration-500"
                            :class="activeStep === step.id
                                ? 'shadow-soft'
                                : ''">
                            <div class="mx-auto fw-bolder fs-2hx d-flex flex-center mb-10 w-60px w-md-75px h-60px h-md-75px rounded-pill transition-all duration-500"
                                :class="activeStep === step.id
                                    ? 'bg-myprimary text-white'
                                    : 'bg-myprimary-light text-myprimary opacity-50'">
                                {{ step.id }}
                            </div>
                            <h3 class="fw-bolder fs-1 mb-4 transition-all duration-500"
                                :class="activeStep === step.id ? 'text-dark' : 'text-gray-500'">
                                {{ step.title }}
                            </h3>
                            <p class="fs-5 fw-semibold mb-0 transition-all duration-500"
                                :class="activeStep === step.id ? 'text-gray-600' : 'text-gray-400'">
                                {{ step.copy }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="safeAdvantages.length" id="advantages" class="container w-100 mw-1100px mx-auto mt-20 pt-20">
            <div class="d-flex flex-column align-items-center w-100 mt-20">
                <div class="px-7 py-3 bg-myprimary-light d-flex align-items-center gap-2 rounded-pill fs-5 mb-7">
                    <i class="ri-medal-fill fs-3 text-myprimary"></i>
                    <span class="fw-bolder text-myprimary">Keunggulan</span>
                </div>
                <h2 class="text-center text-dark lh-sm fw-bolder fs-2tx mb-12 mw-550px mx-auto">
                    Kenapa Memilih Kami?
                </h2>
                <div class="row g-0 justify-content-center w-100">
                    <div v-for="(advantage, index) in safeAdvantages" :key="advantage.id"
                        class="col-12 col-sm-6 card-item" style="margin: -1px;">
                        <div class="d-flex gap-7 p-8 bg-white border border-gray-300 h-100 inner-card">
                            <img :src="advantage.image || '/assets/media/illustrations/img-hero.png'"
                                :alt="advantage.title" class="img-fluid flex-shrink-0 w-40px h-40px shake-icon"
                                :style="{ 'animation-delay': `${index * 1.2}s` }"
                                @error="setFallbackImage($event, 'default')">
                            <div class="flex-fill">
                                <h3 class="text-dark fw-bolder fs-2 mb-2">{{ advantage.title }}</h3>
                                <p class="text-gray-600 fs-5 fw-semibold mb-0">{{ advantage.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="safeBooks.length" id="books" class="bg-white border border-right-0 border-left-0 border-gray-300"
            style="margin-top: 10rem;">
            <div class="container mw-1100px mx-auto my-15 py-20">
                <div class="d-flex flex-column align-items-center align-items-md-start w-100 mb-14">
                    <div class="px-7 py-3 bg-myprimary-light d-flex align-items-center gap-2 rounded-pill fs-5 mb-7">
                        <i class="ri-book-open-fill fs-3 text-myprimary"></i>
                        <span class="fw-bolder text-myprimary">{{ safeBooks.length }} Buku Tersedia</span>
                    </div>
                    <div
                        class="d-flex flex-column w-100 flex-md-row gap-8 align-items-center align-items-md-end justify-content-md-between">
                        <div class="mw-700px">
                            <h2 class="text-center text-md-start text-dark lh-sm fw-bolder fs-2tx mb-6">
                                Jelajahi Terbitan Kami
                            </h2>
                            <p class="text-center text-md-start text-gray-600 fw-semibold lh-lg fs-3 mb-0">
                                Temukan berbagai karya literatur dan publikasi berkualitas yang telah kami terbitkan di
                                {{ setting.site_title }}.
                            </p>
                        </div>
                        <div class="d-none d-md-flex gap-2">
                            <button type="button"
                                class="w-45px h-45px border-none rounded-pill btn btn-icon btn-myprimary-filled book-slider-prev"
                                aria-label="Buku sebelumnya">
                                <i class="ri-arrow-left-line fs-2"></i>
                            </button>
                            <button type="button"
                                class="w-45px h-45px border-none rounded-pill btn btn-icon btn-myprimary-filled book-slider-next"
                                aria-label="Buku berikutnya">
                                <i class="ri-arrow-right-line fs-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="book-slider-wrap">
                    <Swiper class="book-swiper" :modules="bookSliderModules" :slides-per-view="1" :space-between="18"
                        :loop="bookSliderLoop" :autoplay="bookSliderAutoplay" :breakpoints="bookSliderBreakpoints"
                        :navigation="{ prevEl: '.book-slider-prev', nextEl: '.book-slider-next' }"
                        :pagination="{ el: '.book-slider-pagination', clickable: true }">
                        <SwiperSlide v-for="book in safeBooks" :key="book.id">
                            <article
                                class="d-flex flex-column bg-light rounded-4 p-2 border border-gray-300 h-100 cursor-pointer"
                                role="button" tabindex="0" @click="goToBook(book)"
                                @keydown.enter.prevent="goToBook(book)"
                                @keydown.space.prevent="goToBook(book)">
                                <img :src="book.image || '/assets/media/illustrations/img-book.png'" :alt="book.title"
                                    class="img-fluid rounded-3" @error="setFallbackImage($event, 'book')">
                                <div class="p-6 pt-8 d-flex flex-column flex-grow-1">
                                    <h3 class="text-dark fw-bolder fs-2 mb-2">{{ book.title }}</h3>
                                    <p class="text-gray-600 fs-5 fw-semibold mb-5">{{ book.author }} • {{ book.year }}</p>
                                    <div
                                        class="d-flex align-items-center w-100 gap-2 mt-auto pt-5 border-top border-gray-300">
                                        <div class="flex-fill">
                                            <span class="mb-1 fs-6 text-gray-600 fw-semibold">Harga</span>
                                            <p class="fs-3 text-dark fw-bolder mb-0 mt-1">{{ formatPrice(book.price) }}
                                            </p>
                                        </div>
                                        <a :href="whatsappLink" target="_blank" @click.stop
                                            class="btn btn-sm fs-5 btn-myprimary-filled rounded-3 fw-bolder d-inline-flex align-items-center gap-1">
                                            <i class="ri-whatsapp-line fs-3"></i>
                                            Pesan
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </SwiperSlide>
                    </Swiper>
                    <div class="book-slider-pagination"></div>
                </div>
            </div>
        </section>

        <section v-if="safeServices.length" id="services">
            <div class="container mw-1100px mx-auto pt-20">
                <div class="mt-20 d-flex flex-column align-items-center align-items-md-start w-100 mb-14">
                    <div class="px-7 py-3 bg-myprimary-light d-flex align-items-center gap-2 rounded-pill fs-5 mb-7">
                        <i class="ri-service-fill fs-3 text-myprimary"></i>
                        <span class="fw-bolder text-myprimary">Layanan</span>
                    </div>
                    <div
                        class="d-flex flex-column w-100 flex-md-row gap-8 align-items-center align-items-md-end justify-content-md-between">
                        <div class="mw-700px">
                            <h2 class="text-center text-md-start text-dark lh-sm fw-bolder fs-2tx mb-6">
                                Sesuaikan Kebutuhan Anda
                            </h2>
                            <p class="text-center text-md-start text-gray-600 fw-semibold lh-lg fs-3 mb-0">
                                Layanan dibuat modular agar penulis bisa mulai dari konsultasi ringan sampai produksi
                                buku yang lebih lengkap.
                            </p>
                        </div>
                        <a href="#"
                            class="d-none d-md-flex flex-shrink-0 btn justify-content-center btn-myprimary-filled align-items-center gap-1 rounded-3 fs-5">
                            <i class="ri-whatsapp-line fw-normal ms-n1 fs-3 text-myprimary"></i>
                            <span class="fw-bolder">Diskusi Layanan</span>
                        </a>
                    </div>
                </div>
                <div class="row g-6 justify-content-center align-items-stretch">
                    <div v-for="service in safeServices" :key="service.id" class="col-12 col-sm-6 col-xl-4">
                        <article class="d-flex flex-column bg-white rounded-4 p-2 border border-gray-300 h-100">
                            <div class="ratio ratio-4x3 rounded-3 overflow-hidden">
                                <img :src="service.image || '/assets/media/illustrations/img-hero.png'"
                                    :alt="service.name" class="img-fluid object-fit-cover w-100 h-100"
                                    @error="setFallbackImage($event, 'service')">
                            </div>
                            <div class="p-6 pt-8 d-flex flex-column flex-grow-1">
                                <h3 class="text-dark fw-bolder fs-2 mb-2">{{ service.name }}</h3>
                                <p class="text-gray-600 fs-5 fw-semibold mb-5">{{ service.short_description }}</p>

                                <span class="mt-auto fs-3 text-dark fw-bolder">{{ servicePrice(service) }}</span>
                                <button type="button"
                                    @click="openServiceModal(service)"
                                    class="mt-5 w-100 align-items-center justify-content-center d-flex gap-1 fs-5 rounded-3 btn btn-sm btn-hover-icon btn-myprimary-tinted fw-bolder">
                                    <span>Lihat Detail</span>
                                    <i class="ri-arrow-right-up-line fw-bold fs-2 me-n3"></i>
                                </button>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="d-flex justify-content-center d-md-none mt-14">
                    <a href="#"
                        class="btn btn-myprimary-filled d-flex align-items-center justify-content-center gap-1 rounded-3 fs-5">
                        <i class="ri-whatsapp-line fw-normal ms-n1 fs-3 text-myprimary"></i>
                        <span class="fw-bolder">Diskusi Layanan</span>
                    </a>
                </div>
            </div>
        </section>

        <section v-if="safeTestimonials.length" id="testimonials" class="container w-100 mw-1200px mx-auto mt-20 pt-20">
            <div class="d-flex flex-column align-items-center text-center w-100 mt-20">
                <div class="px-7 py-3 bg-myprimary-light d-flex align-items-center gap-2 rounded-pill fs-5 mb-7">
                    <i class="ri-chat-quote-fill fs-3 text-myprimary"></i>
                    <span class="fw-bolder text-myprimary">Testimoni</span>
                </div>
                <h2 class="text-center text-dark lh-sm fw-bolder fs-2tx mb-6 mw-550px mx-auto">
                    Apa Kata Mereka?
                </h2>
                <p class="text-center text-gray-600 fw-semibold lh-lg fs-3 mb-14 mw-650px mx-auto">
                    Dari mereka yang telah merasakan manfaat layanan kami.
                </p>
            </div>

            <div class="testimonial-marquee" aria-label="Daftar testimoni">
                <div class="testimonial-marquee-track">
                    <div class="testimonial-marquee-group me-6">
                        <article v-for="(testimonial, index) in testimonialMarqueeItems"
                            :key="`testimonial-${testimonial.id}-${index}`" class="d-flex flex-column h-100 bg-white border border-gray-300 p-8 w-275px w-sm-300px w-md-325px rounded-4">
                            <div class="d-flex align-items-center gap-4 mb-8">
                                <div class="flex-shrink-0 ratio ratio-1x1 rounded-pill w-50px h-50px overflow-hidden">
                                    <img :src="testimonial.image || '/assets/media/illustrations/img-book.jpeg'"
                                        :alt="testimonial.name" class="img-fluid object-fit-cover w-100 h-100"
                                        @error="setFallbackImage($event, 'avatar')">
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-dark fs-4 fw-bolder mb-1 text-truncate-1">
                                        {{ testimonial.name }}
                                    </h3>
                                    <p class="text-gray-600 fs-5 fw-semibold mb-0 text-truncate-1">
                                        {{ testimonial.position }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-auto d-flex gap-1 mb-5">
                                <i v-for="star in ratingStars(testimonial.rating)" :key="star"
                                    class="ri-star-fill text-myprimary fs-1"></i>
                            </div>
                            <p class="text-dark fs-5 fw-semibold lh-lg mb-0">
                                {{ testimonial.message }}
                            </p>
                        </article>
                    </div>

                    <div class="testimonial-marquee-group">
                        <article v-for="(testimonial, index) in testimonialMarqueeItems"
                            :key="`testimonial-${testimonial.id}-${index}`" class="d-flex flex-column h-100 bg-white border border-gray-300 p-8 w-275px w-sm-300px w-md-325px rounded-4">
                            <div class="d-flex align-items-center gap-4 mb-8">
                                <div class="flex-shrink-0 ratio ratio-1x1 rounded-pill w-50px h-50px overflow-hidden">
                                    <img :src="testimonial.image || '/assets/media/illustrations/img-book.jpeg'"
                                        :alt="testimonial.name" class="img-fluid object-fit-cover w-100 h-100"
                                        @error="setFallbackImage($event, 'avatar')">
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-dark fs-4 fw-bolder mb-1 text-truncate-1">
                                        {{ testimonial.name }}
                                    </h3>
                                    <p class="text-gray-600 fs-5 fw-semibold mb-0 text-truncate-1">
                                        {{ testimonial.position }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-auto d-flex gap-1 mb-5">
                                <i v-for="star in ratingStars(testimonial.rating)" :key="star"
                                    class="ri-star-fill text-myprimary fs-1"></i>
                            </div>
                            <p class="text-dark fs-5 fw-semibold lh-lg mb-0">
                                {{ testimonial.message }}
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="safeBlogs.length" id="blogs" class="bg-white border border-right-0 border-left-0 border-gray-300"
            style="margin-top: 10rem;">
            <div class="container mw-1100px mx-auto my-15 py-20">
                <div class="d-flex flex-column align-items-center align-items-md-start w-100 mb-14">
                    <div
                        class="d-flex flex-column w-100 flex-md-row gap-8 align-items-center align-items-md-end justify-content-md-between">
                        <div class="mw-600px">
                            <h2 class="text-center text-md-start text-dark lh-sm fw-bolder fs-2tx mb-6">
                                Blog Terbaru
                            </h2>
                            <p class="text-center text-md-start text-gray-600 fw-semibold lh-lg fs-3 mb-0">
                                Temukan berbagai blog atau artikel menarik dan informatif yang telah kami publikasikan.
                            </p>
                        </div>
                        <div class="d-none d-md-flex gap-2">
                            <button type="button"
                                class="w-45px h-45px border-none rounded-pill btn btn-icon btn-myprimary-filled blog-slider-prev"
                                aria-label="Artikel sebelumnya">
                                <i class="ri-arrow-left-line fs-2"></i>
                            </button>
                            <button type="button"
                                class="w-45px h-45px border-none rounded-pill btn btn-icon btn-myprimary-filled blog-slider-next"
                                aria-label="Artikel berikutnya">
                                <i class="ri-arrow-right-line fs-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="blog-slider-wrap">
                    <Swiper class="blog-swiper" :modules="blogSliderModules" :slides-per-view="1" :space-between="18"
                        :loop="blogSliderLoop" :autoplay="blogSliderAutoplay" :breakpoints="blogSliderBreakpoints"
                        :navigation="{ prevEl: '.blog-slider-prev', nextEl: '.blog-slider-next' }"
                        :pagination="{ el: '.blog-slider-pagination', clickable: true }">
                        <SwiperSlide v-for="blog in safeBlogs" :key="blog.id">
                            <article 
                                class="d-flex flex-column bg-light rounded-4 p-2 border border-gray-300 h-100 cursor-pointer"
                                role="button" tabindex="0" @click="goToBlog(blog)"
                                @keydown.enter.prevent="goToBlog(blog)"
                                @keydown.space.prevent="goToBlog(blog)">
                                <div class="ratio ratio-4x3 rounded-3 overflow-hidden">
                                    <img :src="blog.image || '/assets/media/illustrations/img-hero.png'"
                                        :alt="blog.title" class="img-fluid object-fit-cover w-100 h-100"
                                        @error="setFallbackImage($event, 'default')">
                                </div>
                                <div class="p-6 pt-8 d-flex flex-column flex-grow-1">
                                    <h3 class="text-dark fw-bolder text-truncate-2 fs-2 mb-2">{{ blog.title }}</h3>
                                    <p class="text-gray-600 fs-5 fw-semibold mb-0">{{ formatDate(blog.created_at) }}</p>
                                </div>
                            </article>
                        </SwiperSlide>
                    </Swiper>
                    <div class="blog-slider-pagination"></div>
                </div>
            </div>
        </section>

        <section v-if="safeFaqs.length" id="faqs" class="container w-100 mw-1100px mx-auto pt-20">
            <div class="mt-20 d-flex flex-column align-items-center text-center w-100">
                <div class="row g-8 ">
                    <div class="col-12 col-lg-5 justify-content-center justify-content-lg-start text-center text-lg-start">
                        <div class="d-inline-flex px-7 py-3 bg-myprimary-light d-flex align-items-center gap-2 rounded-pill fs-5 mb-7">
                            <i class="ri-chat-quote-fill fs-3 text-myprimary"></i>
                            <span class="fw-bolder text-myprimary">FAQs</span>
                        </div>
                        <h2 class="text-dark lh-sm fw-bolder fs-2tx mb-6 mw-550px mx-auto">
                            Yang Paling <br> Sering Ditanyakan
                        </h2>
                        <p class="text-gray-600 fw-semibold lh-lg fs-3 mb-0 mw-650px mx-auto">
                            Masih ada yang ingin ditanyakan? Tim kami siap membantu. <a href="#contact" class="fs-3 fw-bolder btn-link btn-link-myprimary">Hubungi Kami</a>
                        </p>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="d-flex flex-column gap-4">
                            <div v-for="(faq, index) in safeFaqs" :key="faq.id"
                                class="bg-white rounded-4 border overflow-hidden transition-all"
                                :class="activeFaq === faq.id ? 'border-myprimary shadow-soft' : 'border-gray-300'">
                                <button type="button"
                                    class="btn w-100 d-flex align-items-center justify-content-between gap-5 text-start rounded-0 px-6 py-5"
                                    :class="activeFaq === faq.id ? 'bg-myprimary-light' : 'bg-white'"
                                    :aria-expanded="activeFaq === faq.id"
                                    :aria-controls="`faq-answer-${faq.id}`"
                                    @click="activeFaq = activeFaq === faq.id ? null : faq.id">
                                    <span class="d-flex align-items-center gap-4 min-w-0">
                                        <span class="w-30px h-30px flex-shrink-0 rounded-pill d-flex flex-center fs-6 fw-bolder"
                                            :class="activeFaq === faq.id ? 'bg-myprimary text-white' : 'bg-myprimary-light text-myprimary'">
                                            {{ index + 1 }}
                                        </span>
                                        <span class="text-dark fs-5 fw-bolder lh-base">
                                            {{ faq.question }}
                                        </span>
                                    </span>
                                    <span class="w-38px h-38px flex-shrink-0 rounded-pill d-flex flex-center"
                                        :class="activeFaq === faq.id ? 'bg-myprimary text-white' : 'bg-light text-myprimary'">
                                        <i :class="[activeFaq === faq.id ? 'ri-subtract-line text-myprimary' : 'ri-add-line', 'fs-3']"></i>
                                    </span>
                                </button>
                                <div v-if="activeFaq === faq.id" :id="`faq-answer-${faq.id}`"
                                    class="px-6 pb-5 bg-white faq-answer">
                                    <div class="editor-content pt-5 text-start text-gray-600 fs-6 fw-semibold lh-lg faq-answer-content"
                                        v-html="faq.answer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="safeManuscriptCategories.length" id="contact"
            class="container w-100 mw-1100px mx-auto mt-20 pt-20">
                <div class="row align-items-stretch g-6 g-lg-10 pt-20">
                    <div class="col-12 col-lg-5">
                        <div class="h-100 bg-myprimary rounded-4 p-10 p-lg-12 d-flex flex-column">
                            <h2 class="fs-2tx text-white fw-bolder mb-5">
                                Siap Menerbitkan Karya Anda?
                            </h2>
                            <p class="text-white opacity-75 fs-3 fw-semibold lh-lg mb-14">
                                Pilih kategori naskah yang sesuai, siapkan berkas utama, lalu hubungi tim kami untuk
                                arahan pengiriman dan proses penerbitan.
                            </p>
                            <div class="d-flex flex-wrap gap-4 mt-auto">
                                <a :href="whatsappLink" target="_blank" class="" aria-label="WhatsApp">
                                    <i class="ri-whatsapp-line fs-2x text-white"></i>
                                </a>
                                <a v-if="setting?.email" :href="`mailto:${setting.email}`" class=""
                                    aria-label="Email">
                                    <i class="ri-mail-line fs-2x text-white"></i>
                                </a>
                                <a v-if="setting?.instagram" :href="setting.instagram" target="_blank"
                                    class="" aria-label="Instagram">
                                    <i class="ri-instagram-line fs-2x text-white"></i>
                                </a>
                                <a v-if="setting?.linkedin" :href="setting.linkedin" target="_blank"
                                    class="" aria-label="LinkedIn">
                                    <i class="ri-linkedin-box-fill fs-2x text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="h-100">
                            <div class="row g-6">
                                <div v-for="(category, index) in safeManuscriptCategories" :key="category.id" class="col-12">
                                    <article class="d-flex gap-7 p-8 bg-white border border-gray-300 h-100 rounded-4">
                                        <img :src="category.image || '/assets/media/illustrations/img-hero.png'"
                                            :alt="category.title" class="img-fluid flex-shrink-0 w-55px h-55px shake-icon"
                                            :style="{ 'animation-delay': `${index * 1.2}s` }"
                                            @error="setFallbackImage($event, 'default')">
                                        <div class="flex-fill">
                                            <h3 class="text-dark fw-bolder fs-2 mb-2">{{ category.title }}</h3>
                                            <p class="text-gray-600 fs-5 fw-semibold mb-5">{{ category.description }}</p>
                                            <div class="d-flex flex-wrap gap-3 align-self-start">
                                                <span class="px-4 py-2 bg-gray-200 text-gray-600 rounded-pill fs-7 fw-bolder">
                                                    {{ category.requirements.length }} Persyaratan
                                                </span>
                                                <span class="px-4 py-2 bg-gray-200 text-gray-600 rounded-pill fs-7 fw-bolder">
                                                    {{ category.attachments.length }} Lampiran
                                                </span>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <div id="serviceDetailModal" class="modal fade service-bootstrap-modal" tabindex="-1"
            aria-labelledby="serviceDetailModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
                <div class="modal-content service-modal-panel">
                    <button type="button" class="service-modal-close" data-bs-dismiss="modal"
                        aria-label="Tutup detail layanan">
                        <i class="ri-close-line fs-2"></i>
                    </button>

                    <div v-if="selectedService" class="modal-body p-0">
                        <div class="service-modal-grid">
                            <div class="service-modal-media">
                                <div class="service-modal-image-frame">
                                    <img :src="selectedService.image || '/assets/media/illustrations/img-hero.png'"
                                        :alt="selectedService.name" class="service-modal-image"
                                        @error="setFallbackImage($event, 'service')">
                                </div>
                            </div>

                            <div class="service-modal-content">

                                <h2 id="serviceDetailModalTitle" class="service-modal-title text-dark fw-bolder mb-4">
                                    {{ selectedService.name }}
                                </h2>
                                <p class="text-gray-600 fs-5 fw-semibold lh-lg mb-7">
                                    {{ selectedService.short_description || 'Detail singkat layanan belum tersedia.' }}
                                </p>

                                <div v-if="selectedService.description"
                                    class="service-modal-description editor-content text-dark fs-5 fw-semibold lh-lg mb-7"
                                    v-html="selectedService.description"></div>

                                <div v-if="selectedServicePackages.length" class="service-modal-section">
                                    <h3 class="text-dark fw-bolder fs-2 mb-4">Paket Layanan</h3>
                                    <div class="service-modal-package-list">
                                        <article v-for="servicePackage in selectedServicePackages"
                                            :key="servicePackage.id || servicePackage.name"
                                            class="service-modal-package">
                                            <div class="d-flex align-items-start justify-content-between gap-4">
                                                <div>
                                                    <h4 class="text-dark fw-bolder fs-4 mb-2">
                                                        {{ servicePackage.name }}
                                                    </h4>
                                                    <span v-if="servicePackage.recommendation"
                                                        class="service-modal-package-badge">
                                                        Rekomendasi
                                                    </span>
                                                </div>
                                                <strong class="text-dark fs-4 fw-bolder text-end">
                                                    {{ formatServicePackagePrice(servicePackage.price) }}
                                                </strong>
                                            </div>
                                            <div v-if="servicePackage.features?.length"
                                                class="mt-4 d-flex flex-column gap-2">
                                                <div v-for="feature in servicePackage.features" :key="feature"
                                                    class="d-flex align-items-start gap-2">
                                                    <i class="ri-check-line text-myprimary fs-4 mt-1"></i>
                                                    <span class="text-gray-600 fs-6 fw-semibold">{{ feature }}</span>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                </div>

                                <div v-if="selectedServiceSections.length" class="service-modal-section">
                                    <h3 class="text-dark fw-bolder fs-2 mb-4">Konten Layanan</h3>
                                    <div class="d-flex flex-column gap-4">
                                        <article v-for="(section, index) in selectedServiceSections"
                                            :key="section.title || index"
                                            class="service-modal-detail-block">
                                            <div class="d-flex align-items-start justify-content-between gap-4 mb-3">
                                                <h4 class="text-dark fw-bolder fs-4 mb-0">
                                                    {{ section.title || `Konten ${index + 1}` }}
                                                </h4>
                                                <span class="service-modal-type-badge">
                                                    {{ serviceSectionTypeLabel(section.type) }}
                                                </span>
                                            </div>

                                            <p v-if="section.type === 'text' && section.content"
                                                class="service-modal-detail-copy text-gray-600 fs-5 fw-semibold lh-lg mb-0">
                                                {{ section.content }}
                                            </p>

                                            <ul v-else-if="section.type === 'list' && section.items.length"
                                                class="service-modal-list">
                                                <li v-for="item in section.items" :key="item">
                                                    <i class="ri-checkbox-circle-fill text-myprimary fs-3"></i>
                                                    <span>{{ item }}</span>
                                                </li>
                                            </ul>

                                            <ol v-else-if="section.type === 'steps' && section.items.length"
                                                class="service-modal-steps">
                                                <li v-for="(item, itemIndex) in section.items" :key="item">
                                                    <span class="service-modal-step-number">{{ itemIndex + 1 }}</span>
                                                    <span>{{ item }}</span>
                                                </li>
                                            </ol>

                                            <p v-else class="text-gray-500 fs-6 fw-semibold mb-0">
                                                Konten belum tersedia.
                                            </p>
                                        </article>
                                    </div>
                                </div>

                                <div class="service-modal-actions">
                                    <a :href="serviceWhatsAppLink" target="_blank"
                                        class="btn btn-myprimary-filled btn-hover-icon rounded-3 fw-bolder fs-5 d-inline-flex align-items-center justify-content-center gap-1">
                                        Diskusi Layanan
                                        <i class="ri-whatsapp-line fs-3 me-n2"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-mytertiary-tinted rounded-3 fw-bolder fs-5"
                                        data-bs-dismiss="modal">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutUser>
</template>

<script>
import { Head, router } from '@inertiajs/vue3';
import LayoutUser from '../../Layouts/User.vue';
import { computed, nextTick, ref, onMounted, onUnmounted, watch } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { A11y, Autoplay, Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export default {
    components: {
        Head,
        LayoutUser,
        Swiper,
        SwiperSlide,
    },

    props: {
        blogs: {
            type: Array,
            default: () => [],
        },
        process_steps: {
            type: Array,
            default: () => [],
        },
        books: {
            type: Array,
            default: () => [],
        },
        services: {
            type: Array,
            default: () => [],
        },
        faqs: {
            type: Array,
            default: () => [],
        },
        testimonials: {
            type: Array,
            default: () => [],
        },
        advantages: {
            type: Array,
            default: () => [],
        },
        manuscript_categories: {
            type: Array,
            default: () => [],
        },
        hero_section: {
            type: Object,
            default: () => ({}),
        },
        setting: {
            type: Object,
            default: () => ({}),
        },
    },

    setup(props) {
        const activeFaq = ref(null);

        const safeBlogs = computed(() => props.blogs || []);
        const safeProcessSteps = computed(() => props.process_steps || []);
        const safeBooks = computed(() => props.books || []);
        const safeServices = computed(() => props.services || []);
        const safeFaqs = computed(() => props.faqs || []);
        const safeTestimonials = computed(() => props.testimonials || []);
        const safeAdvantages = computed(() => props.advantages || []);
        const safeManuscriptCategories = computed(() => props.manuscript_categories || []);
        const safeHeroSection = computed(() => props.hero_section || {});
        const testimonialMarqueeItems = computed(() => {
            if (!safeTestimonials.value.length) {
                return [];
            }

            const repeatCount = Math.max(1, Math.ceil(6 / safeTestimonials.value.length));

            return Array.from({ length: repeatCount }).flatMap(() => safeTestimonials.value);
        });

        const pageTitle = computed(() => props.setting?.meta_title || props.setting?.site_title || 'Pustaka Riyadz');
        const heroHeading = computed(() => safeHeroSection.value.heading || props.setting?.site_title || 'Pustaka Riyadz');
        const heroSubheading = computed(() => safeHeroSection.value.subheading || props.setting?.meta_description || '');
        const heroImage = computed(() => safeHeroSection.value.image || '/assets/media/illustrations/img-books.png');

        const bookSliderModules = [A11y, Autoplay, Navigation, Pagination];
        const bookModalModules = [A11y, Pagination];
        const blogSliderModules = [A11y, Autoplay, Navigation, Pagination];
        const bookSliderBreakpoints = {
            576: {
                slidesPerView: 1.12,
                spaceBetween: 18,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 24,
            },
        };
        const blogSliderBreakpoints = {
            576: {
                slidesPerView: 1.12,
                spaceBetween: 18,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 24,
            },
        };
        const bookSliderAutoplay = computed(() => {
            if (safeBooks.value.length <= 1) {
                return false;
            }

            return {
                delay: 4200,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            };
        });
        const bookSliderLoop = computed(() => safeBooks.value.length > 3);
        const blogSliderAutoplay = computed(() => {
            if (safeBlogs.value.length <= 1) {
                return false;
            }

            return {
                delay: 4600,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            };
        });
        const blogSliderLoop = computed(() => safeBlogs.value.length > 3);
        const selectedBook = ref(null);
        const selectedService = ref(null);
        let originalBodyOverflow = '';
        let serviceModalInstance = null;
        let serviceModalElement = null;
        const isAnyModalOpen = computed(() => Boolean(selectedBook.value));
        const handleServiceModalHidden = () => {
            selectedService.value = null;
        };

        const selectedBookImages = computed(() => {
            if (!selectedBook.value) {
                return [];
            }

            const images = selectedBook.value.images?.length
                ? selectedBook.value.images
                : [selectedBook.value.image];

            return images.filter(Boolean);
        });

        const selectedBookDetails = computed(() => {
            if (!selectedBook.value) {
                return [];
            }

            const book = selectedBook.value;

            return [
                { label: 'Penerbit', value: book.publisher },
                { label: 'Penulis', value: book.author },
                { label: 'Kategori', value: book.category },
                { label: 'Subjek', value: book.subject },
                { label: 'ISBN', value: book.isbn },
                { label: 'Dimensi', value: book.dimensions },
                { label: 'Halaman', value: book.pages },
                { label: 'Tahun', value: book.year },
            ].filter((item) => item.value);
        });

        const selectedBookDescription = computed(() => {
            return selectedBook.value?.description
                || selectedBook.value?.excerpt
                || 'Deskripsi buku belum tersedia.';
        });

        const normalizeListItems = (value) => {
            if (Array.isArray(value)) {
                return value.map((item) => String(item).trim()).filter(Boolean);
            }

            if (typeof value === 'string') {
                return value.split(/\r?\n/).map((item) => item.trim()).filter(Boolean);
            }

            return [];
        };

        const normalizeServiceSection = (section, index) => {
            if (typeof section === 'string') {
                return {
                    title: `Konten ${index + 1}`,
                    type: 'text',
                    content: section,
                    items: [],
                };
            }

            const hasItems = normalizeListItems(section?.items).length > 0;
            const type = ['text', 'list', 'steps'].includes(section?.type)
                ? section.type
                : (hasItems ? 'list' : 'text');
            const content = typeof section?.content === 'string'
                ? section.content
                : (section?.description || '');

            return {
                title: section?.title || section?.heading || section?.name || `Konten ${index + 1}`,
                type,
                content,
                items: type === 'text' ? [] : normalizeListItems(section?.items || section?.content),
            };
        };

        const selectedServicePackages = computed(() => {
            const packages = selectedService.value?.packages || [];

            if (!Array.isArray(packages)) {
                return [];
            }

            return packages.map((servicePackage) => ({
                ...servicePackage,
                features: normalizeListItems(servicePackage.features),
            }));
        });

        const selectedServiceSections = computed(() => {
            const sections = selectedService.value?.sections || [];

            if (!Array.isArray(sections)) {
                return [];
            }

            return sections
                .filter(Boolean)
                .map(normalizeServiceSection);
        });

        const serviceSectionTypeLabel = (type) => {
            const labels = {
                text: 'Teks Paragraf',
                list: 'Daftar Poin',
                steps: 'Alur Berurutan',
            };

            return labels[type] || 'Konten';
        };

        const openBookModal = (book) => {
            selectedBook.value = book;
        };

        const openServiceModal = async (service) => {
            selectedService.value = service;

            await nextTick();

            if (!serviceModalElement || !window.bootstrap?.Modal) {
                return;
            }

            serviceModalInstance = window.bootstrap.Modal.getOrCreateInstance(serviceModalElement);
            serviceModalInstance.show();
        };

        const goToBook = (book) => {
            if (book?.slug) {
                router.visit(`/books/${book.slug}`);
            }
        };

        const goToBlog = (blog) => {
            if (blog?.slug) {
                router.visit(`/blogs/${blog.slug}`);
            }
        };

        const closeBookModal = () => {
            selectedBook.value = null;
        };

        const closeServiceModal = () => {
            if (serviceModalInstance) {
                serviceModalInstance.hide();
                return;
            }

            selectedService.value = null;
        };

        const handleModalKeydown = (event) => {
            if (event.key !== 'Escape') {
                return;
            }

            if (selectedBook.value) {
                closeBookModal();
            }
        };

        watch(isAnyModalOpen, (isOpen, wasOpen) => {
            if (typeof document === 'undefined') {
                return;
            }

            if (isOpen && !wasOpen) {
                originalBodyOverflow = document.body.style.overflow;
                document.body.style.overflow = 'hidden';
            }

            if (!isOpen && wasOpen) {
                document.body.style.overflow = originalBodyOverflow;
            }
        });

        const defaultProcessSteps = [
            { id: 1, title: 'Unggah Dokumen', copy: 'Lengkapi berkas administrasi sesuai persyaratan yang ditentukan.' },
            { id: 2, title: 'Verifikasi Data', copy: 'Tim admin akan memeriksa validitas dokumen yang telah dikirimkan.' },
            { id: 3, title: 'Selesai Terintegrasi', copy: 'Dokumen berhasil divalidasi dan siap digunakan dalam sistem.' },
        ];
        const processSteps = computed(() => safeProcessSteps.value.length ? safeProcessSteps.value : defaultProcessSteps);

        const activeStep = ref(1);
        let timer = null;

        const startPulse = () => {
            timer = setInterval(() => {
                activeStep.value = (activeStep.value % processSteps.value.length) + 1;
            }, 1500);
        };

        onMounted(() => {
            startPulse();

            if (typeof window !== 'undefined') {
                window.addEventListener('keydown', handleModalKeydown);
            }

            if (typeof document !== 'undefined') {
                serviceModalElement = document.getElementById('serviceDetailModal');
                serviceModalElement?.addEventListener('hidden.bs.modal', handleServiceModalHidden);
            }
        });

        onUnmounted(() => {
            if (timer) clearInterval(timer);

            if (typeof window !== 'undefined') {
                window.removeEventListener('keydown', handleModalKeydown);
            }

            if (typeof document !== 'undefined') {
                document.body.style.overflow = originalBodyOverflow;
                serviceModalElement?.removeEventListener('hidden.bs.modal', handleServiceModalHidden);
            }

            serviceModalInstance?.dispose();
        });

        const overviewStats = computed(() => [
            {
                label: 'Koleksi Buku',
                value: `${safeBooks.value.length}+`,
            },
            {
                label: 'Layanan Aktif',
                value: `${safeServices.value.length}+`,
            },
            {
                label: 'Cerita Pembaca',
                value: `${safeTestimonials.value.length}+`,
            },
            {
                label: 'Artikel Literasi',
                value: `${safeBlogs.value.length}+`,
            },
        ]);

        const advantageIcons = [
            'ri-shield-check-line',
            'ri-compasses-2-line',
            'ri-quill-pen-line',
            'ri-stack-line',
            'ri-sparkling-2-line',
            'ri-book-marked-line',
        ];

        const serviceIcons = [
            'ri-draft-line',
            'ri-edit-2-line',
            'ri-book-open-line',
            'ri-palette-line',
            'ri-printer-line',
            'ri-megaphone-line',
        ];

        const advantageIcon = (index) => advantageIcons[index % advantageIcons.length];
        const serviceIcon = (index) => serviceIcons[index % serviceIcons.length];

        const whatsappNumber = computed(() => {
            const raw = props.setting?.whatsapp;

            if (!raw) {
                return '';
            }

            let number = raw.toString().replace(/\D/g, '');

            if (number.startsWith('0')) {
                number = `62${number.substring(1)}`;
            } else if (!number.startsWith('62')) {
                number = `62${number}`;
            }

            return number;
        });

        const whatsappLink = computed(() => {
            return whatsappNumber.value ? `https://wa.me/${whatsappNumber.value}` : '#contact';
        });

        const serviceWhatsAppLink = computed(() => {
            if (!selectedService.value || !whatsappNumber.value) {
                return whatsappLink.value;
            }

            const message = encodeURIComponent(`Halo, saya ingin diskusi layanan "${selectedService.value.name}".`);
            return `https://wa.me/${whatsappNumber.value}?text=${message}`;
        });

        const formattedWhatsApp = computed(() => {
            if (!whatsappNumber.value) {
                return 'WhatsApp Pustaka Riyadz';
            }

            const localNumber = whatsappNumber.value.replace(/^62/, '');
            const part1 = localNumber.substring(0, 3);
            const part2 = localNumber.substring(3, 7);
            const part3 = localNumber.substring(7);

            return `+62 ${part1}-${part2}-${part3}`;
        });

        const formatPrice = (price) => {
            if (price === null || price === undefined || price === '') {
                return 'Hub. Admin';
            }

            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            }).format(Number(price));
        };

        const formatDate = (date) => {
            if (!date) {
                return 'Tanggal belum tersedia';
            }

            const parsedDate = new Date(date);

            if (Number.isNaN(parsedDate.getTime())) {
                return date;
            }

            return new Intl.DateTimeFormat('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
            }).format(parsedDate);
        };

        const servicePrice = (service) => {
            if (service.starting_price) {
                return service.starting_price;
            }

            const packages = service.packages || [];
            if (packages.length > 1) {
                // Sort packages by price (ascending)
                const sorted = [...packages].sort((a, b) => Number(a.price) - Number(b.price));
                const first = sorted[0]?.price;
                const last = sorted[sorted.length - 1]?.price;
                if (first && last && first !== last) {
                    return `${first} - ${last}`;
                } else if (first) {
                    return `${first}`;
                }
            } else if (packages.length === 1) {
                return `${packages[0].price}`;
            }
            return 'Harga Hub. Admin';
        };

        const serviceHighlights = (service) => {
            const packageFeatures = service.packages?.flatMap((servicePackage) => normalizeListItems(servicePackage.features)) || [];

            if (packageFeatures.length) {
                return packageFeatures.slice(0, 3);
            }

            const sectionTitles = service.sections?.map((section) => section.title).filter(Boolean) || [];

            return sectionTitles.slice(0, 3);
        };

        const selectedServiceHighlights = computed(() => {
            return selectedService.value ? serviceHighlights(selectedService.value) : [];
        });

        const formatServicePackagePrice = (price) => {
            if (price === null || price === undefined || price === '') {
                return 'Hub. Admin';
            }

            const numericPrice = Number(price);

            if (!Number.isNaN(numericPrice)) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0,
                }).format(numericPrice);
            }

            return price;
        };

        const ratingStars = (rating) => {
            const value = Math.max(1, Math.min(5, Math.round(Number(rating) || 5)));

            return Array.from({ length: value }, (_, index) => index + 1);
        };

        const setFallbackImage = (event, type = 'default') => {
            const fallbacks = {
                avatar: '/assets/media/illustrations/img-book.jpeg',
                book: '/assets/media/illustrations/img-book.png',
                hero: '/assets/media/illustrations/img-books.png',
                service: '/assets/media/illustrations/img-hero.png',
                default: '/assets/media/illustrations/empty.png',
            };

            event.target.src = fallbacks[type] || fallbacks.default;
        };

        return {
            activeFaq,
            pageTitle,
            safeBlogs,
            safeProcessSteps,
            safeBooks,
            safeServices,
            safeFaqs,
            safeTestimonials,
            safeAdvantages,
            safeManuscriptCategories,
            heroHeading,
            heroSubheading,
            heroImage,
            testimonialMarqueeItems,
            bookSliderModules,
            bookModalModules,
            blogSliderModules,
            bookSliderBreakpoints,
            blogSliderBreakpoints,
            bookSliderAutoplay,
            bookSliderLoop,
            blogSliderAutoplay,
            blogSliderLoop,
            selectedBook,
            selectedService,
            selectedBookImages,
            selectedBookDetails,
            selectedBookDescription,
            selectedServicePackages,
            selectedServiceSections,
            selectedServiceHighlights,
            processSteps,
            activeStep,
            overviewStats,
            formattedWhatsApp,
            whatsappLink,
            serviceWhatsAppLink,
            advantageIcon,
            serviceIcon,
            formatPrice,
            formatDate,
            formatServicePackagePrice,
            servicePrice,
            serviceSectionTypeLabel,
            serviceHighlights,
            goToBook,
            goToBlog,
            openServiceModal,
            closeServiceModal,
            openBookModal,
            closeBookModal,
            ratingStars,
            setFallbackImage,
        };
    }
}
</script>

<style scoped>
.landing-section {
    --landing-ink: var(--slate-900);
    --landing-muted: var(--slate-500);
    --landing-line: rgba(203, 213, 225, 0.76);
    --landing-soft: var(--slate-50);
    --landing-accent: var(--base-color-500);
    --landing-accent-dark: var(--base-color-700);
    --landing-shadow: 0 16px 42px rgba(15, 23, 42, 0.06);
    --landing-shadow-hover: 0 22px 48px rgba(15, 23, 42, 0.1);
    position: relative;
    overflow: hidden;
    padding: 7rem 0;
}

.landing-muted-section {
    border-top: 1px solid rgba(226, 232, 240, 0.82);
    border-bottom: 1px solid rgba(226, 232, 240, 0.82);
    background:
        linear-gradient(180deg, rgba(248, 250, 252, 0.95) 0%, #ffffff 100%);
}

.landing-section-head {
    margin-bottom: 3rem;
}

.landing-section-head.text-center {
    max-width: 760px;
}

.landing-section-head .section-copy {
    max-width: 690px;
}

.landing-reveal {
    opacity: 0;
    transform: translateY(18px);
    animation: landingFadeUp 0.65s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    animation-delay: var(--reveal-delay, 0ms);
}

.section-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.55rem;
    min-height: 38px;
    border: 1px solid rgba(249, 115, 22, 0.22);
    border-radius: 999px;
    background: #fff7ed;
    color: var(--landing-accent-dark);
    padding: 0.55rem 0.95rem;
    font-size: 0.88rem;
    font-weight: 800;
    letter-spacing: 0;
    line-height: 1;
    margin-bottom: 1rem;
}

.section-eyebrow i {
    font-size: 1.15rem;
}

.section-eyebrow-light {
    border-color: rgba(255, 255, 255, 0.24);
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
}

.section-heading {
    font-size: 2.85rem;
    line-height: 1.14;
    letter-spacing: 0;
}

.section-copy,
.card-copy,
.testimonial-message {
    line-height: 1.78;
}

.feature-icon {
    width: 52px;
    height: 52px;
    min-width: 52px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(249, 115, 22, 0.18);
    border-radius: 8px;
    background: #fff7ed;
}

.feature-icon-light {
    background: #ffffff;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
}

.card-title {
    color: var(--landing-ink);
    font-size: 1.12rem;
    line-height: 1.42;
    margin: 0 0 0.75rem;
}

.service-note {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    border: 1px solid var(--landing-line);
    border-radius: 8px;
    background: #ffffff;
    padding: 1.35rem;
    box-shadow: var(--landing-shadow);
    margin-bottom: 1.5rem;
}

.service-card {
    display: flex;
    flex-direction: column;
    min-height: 100%;
}

.service-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    padding: 1.4rem 1.4rem 1rem;
}

.service-price {
    max-width: 185px;
    border: 1px solid rgba(34, 197, 94, 0.18);
    border-radius: 999px;
    background: #f0fdf4;
    color: #15803d;
    padding: 0.52rem 0.85rem;
    font-size: 0.78rem;
    line-height: 1.35;
    text-align: right;
}

.service-media,
.blog-image-wrapper,
.book-slide-cover {
    background: var(--landing-soft);
    overflow: hidden;
}

.service-media {
    aspect-ratio: 16 / 9;
    margin: 0 1.4rem;
    border-radius: 8px;
}

.service-image,
.book-image,
.blog-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s ease;
}

.service-card:hover .service-image,
.book-slide-card:hover .book-image,
.blog-card:hover .blog-image {
    transform: scale(1.045);
}

.service-card-body,
.book-slide-content,
.blog-card-body {
    display: flex;
    flex: 1;
    flex-direction: column;
    min-width: 0;
    padding: 1.4rem;
}

.service-highlights {
    display: grid;
    gap: 0.65rem;
    margin: 0.65rem 0 1.35rem;
}

.service-highlight {
    display: flex;
    align-items: flex-start;
    gap: 0.55rem;
}

.inline-action {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: var(--landing-accent-dark);
    transition: gap 0.2s ease, color 0.2s ease;
}

.inline-action:hover {
    gap: 0.7rem;
    color: var(--landing-accent);
}

.book-slider-wrap,
.blog-slider-wrap {
    min-width: 0;
}

.book-slider-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.book-swiper,
.blog-swiper {
    margin: -0.25rem -0.5rem;
    padding: 0.25rem 0.5rem 1rem;
}

.book-swiper :deep(.swiper-wrapper),
.blog-swiper :deep(.swiper-wrapper) {
    align-items: stretch;
}

.book-swiper :deep(.swiper-slide),
.blog-swiper :deep(.swiper-slide) {
    height: auto;
}

.book-slider-pagination,
.blog-slider-pagination {
    position: static;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    min-height: 28px;
    margin-top: 0.75rem;
}

.book-slider-pagination :deep(.swiper-pagination-bullet),
.blog-slider-pagination :deep(.swiper-pagination-bullet) {
    width: 8px;
    height: 8px;
    margin: 0 !important;
    background: var(--slate-200);
    opacity: 1;
    transition: width 0.2s ease, background 0.2s ease;
}

.book-slider-pagination :deep(.swiper-pagination-bullet-active),
.blog-slider-pagination :deep(.swiper-pagination-bullet-active) {
    width: 24px;
    border-radius: 999px;
    background: var(--base-color-500);
}

.book-modal-trigger {
    cursor: pointer;
}

.book-modal-trigger:focus-visible {
    outline: 2px solid var(--base-color-500);
    outline-offset: 4px;
}

.book-modal-backdrop {
    position: fixed;
    inset: 0;
    z-index: 1080;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    background: rgba(15, 23, 42, 0.62);
    overflow-y: auto;
    animation: bookModalFade 0.2s ease;
}

.book-modal-panel {
    position: relative;
    width: min(1040px, 100%);
    max-height: calc(100vh - 3rem);
    border: 1px solid rgba(226, 232, 240, 0.95);
    border-radius: 8px;
    background: #ffffff;
    box-shadow: 0 28px 80px rgba(15, 23, 42, 0.24);
    overflow: hidden;
    animation: bookModalRise 0.24s ease;
}

.book-modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    z-index: 2;
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(226, 232, 240, 0.95);
    border-radius: 8px;
    background: #ffffff;
    color: var(--slate-600);
    cursor: pointer;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
    transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
}

.book-modal-close:focus-visible {
    outline: 2px solid var(--base-color-500);
    outline-offset: 2px;
}

.book-modal-close:hover {
    background: #fff7ed;
    color: var(--base-color-600);
    transform: translateY(-1px);
}

.book-modal-grid {
    display: grid;
    grid-template-columns: minmax(0, 0.88fr) minmax(0, 1.12fr);
    max-height: calc(100vh - 3rem);
}

.book-modal-media {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 620px;
    border-right: 1px solid rgba(226, 232, 240, 0.9);
    background:
        linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    padding: 2rem;
}

.book-modal-swiper {
    width: 100%;
}

.book-modal-swiper :deep(.swiper-pagination) {
    position: static;
    display: flex;
    justify-content: center;
    gap: 0.45rem;
    margin-top: 1rem;
}

.book-modal-swiper :deep(.swiper-pagination-bullet) {
    width: 8px;
    height: 8px;
    margin: 0 !important;
    background: var(--slate-300);
    opacity: 1;
}

.book-modal-swiper :deep(.swiper-pagination-bullet-active) {
    width: 24px;
    border-radius: 999px;
    background: var(--base-color-500);
}

.book-modal-image-frame {
    width: 100%;
    aspect-ratio: 3 / 4;
    border: 1px solid rgba(226, 232, 240, 0.95);
    border-radius: 8px;
    background: #ffffff;
    overflow: hidden;
}

.book-modal-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.book-modal-content {
    max-height: calc(100vh - 3rem);
    padding: 2.25rem;
    overflow-y: auto;
}

.book-modal-title {
    font-size: 2.25rem;
    line-height: 1.16;
}

.book-modal-price {
    border: 1px solid rgba(249, 115, 22, 0.18);
    border-radius: 8px;
    background: #fff7ed;
    padding: 1.15rem 1.25rem;
}

.book-modal-meta-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.9rem;
}

.book-modal-meta-item {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
    min-width: 0;
    border: 1px solid rgba(226, 232, 240, 0.9);
    border-radius: 8px;
    background: #ffffff;
    padding: 1rem;
}

.book-modal-meta-item span {
    color: var(--slate-500);
    font-size: 0.76rem;
    font-weight: 800;
}

.book-modal-meta-item strong {
    color: var(--slate-900);
    font-size: 0.96rem;
    overflow-wrap: anywhere;
}

.book-modal-description {
    border-top: 1px solid rgba(226, 232, 240, 0.9);
    padding-top: 1.5rem;
}

.book-modal-description p {
    line-height: 1.85;
    white-space: pre-line;
}

.book-modal-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.85rem;
    border-top: 1px solid rgba(226, 232, 240, 0.9);
    margin-top: 1.75rem;
    padding-top: 1.5rem;
}

.service-bootstrap-modal .modal-dialog {
    max-width: min(800px, calc(100% - 1.5rem));
}

.service-bootstrap-modal .modal-body {
    overflow: hidden;
}

.service-modal-panel {
    position: relative;
    width: 100%;
    max-height: calc(100vh - 3rem);
    border: 1px solid rgba(226, 232, 240, 0.95);
    border-radius: 8px;
    background: #ffffff;
    box-shadow: 0 28px 80px rgba(15, 23, 42, 0.24);
    overflow: hidden;
}

.service-modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    z-index: 3;
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(226, 232, 240, 0.95);
    border-radius: 8px;
    background: #ffffff;
    color: var(--slate-600);
    cursor: pointer;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
    transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
}

.service-modal-close:focus-visible {
    outline: 2px solid var(--base-color-500);
    outline-offset: 2px;
}

.service-modal-close:hover {
    background: #fff7ed;
    color: var(--base-color-600);
    transform: translateY(-1px);
}

.service-modal-grid {
    display: grid;
    grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
    max-height: calc(100vh - 3rem);
}

.service-modal-media {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    border-right: 1px solid rgba(226, 232, 240, 0.9);
    background:
        linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    padding: 2rem;
}

.service-modal-image-frame {
    width: 100%;
    aspect-ratio: 4 / 3;
    border: 1px solid rgba(226, 232, 240, 0.95);
    border-radius: 8px;
    background: #ffffff;
    overflow: hidden;
}

.service-modal-image {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
}

.service-modal-content {
    max-height: calc(100vh - 3rem);
    padding: 2.25rem;
    overflow-y: auto;
}

.service-modal-title {
    font-size: 2.15rem;
    line-height: 1.16;
}

.service-modal-chip {
    display: inline-flex;
    align-items: center;
    min-height: 30px;
    border: 1px solid rgba(249, 115, 22, 0.14);
    border-radius: 999px;
    background: #fff7ed;
    color: var(--base-color-700);
    padding: 0.38rem 0.75rem;
    font-size: 0.74rem;
    font-weight: 800;
}

.service-modal-chip-muted {
    border-color: rgba(100, 116, 139, 0.14);
    background: #f1f5f9;
    color: #64748b;
}

.service-modal-description {
    border-top: 1px solid rgba(226, 232, 240, 0.9);
    padding-top: 1.5rem;
}

.service-modal-description :deep(p:last-child) {
    margin-bottom: 0;
}

.service-modal-section {
    border-top: 1px solid rgba(226, 232, 240, 0.9);
    padding-top: 1.5rem;
    margin-top: 1.5rem;
}

.service-modal-highlight-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.85rem;
}

.service-modal-highlight,
.service-modal-detail-block {
    min-width: 0;
    border: 1px solid rgba(226, 232, 240, 0.9);
    border-radius: 8px;
    background: #ffffff;
    padding: 1rem;
}

.service-modal-detail-copy :deep(p:last-child) {
    margin-bottom: 0;
}

.service-modal-detail-copy {
    white-space: pre-line;
}

.service-modal-type-badge {
    display: inline-flex;
    align-items: center;
    min-height: 26px;
    border-radius: 999px;
    background: #f1f5f9;
    color: #64748b;
    padding: 0.25rem 0.65rem;
    font-size: 0.7rem;
    font-weight: 800;
    white-space: nowrap;
}

.service-modal-list,
.service-modal-steps {
    display: grid;
    gap: 0.75rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.service-modal-list li,
.service-modal-steps li {
    display: flex;
    align-items: flex-start;
    gap: 0.65rem;
    color: var(--slate-600);
    font-size: 1.075rem;
    font-weight: 600;
    line-height: 1.65;
}

.service-modal-step-number {
    width: 28px;
    height: 28px;
    flex: 0 0 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: var(--base-color-100);
    color: var(--base-color-700);
    font-size: 0.78rem;
    font-weight: 800;
}

.service-modal-highlight {
    display: flex;
    align-items: flex-start;
    gap: 0.65rem;
}

.service-modal-package-list {
    display: grid;
    gap: 0.9rem;
}

.service-modal-package {
    min-width: 0;
    border: 1px solid rgba(226, 232, 240, 0.9);
    border-radius: 8px;
    background: #ffffff;
    padding: 1rem;
}

.service-modal-package-badge {
    display: inline-flex;
    align-items: center;
    min-height: 26px;
    border-radius: 999px;
    background: var(--base-color-100);
    color: var(--base-color-700);
    padding: 0.25rem 0.65rem;
    font-size: 0.7rem;
    font-weight: 800;
}

.service-modal-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.85rem;
    border-top: 1px solid rgba(226, 232, 240, 0.9);
    margin-top: 1.75rem;
    padding-top: 1.5rem;
}

.book-chip {
    display: inline-flex;
    align-items: center;
    min-height: 28px;
    border: 1px solid rgba(249, 115, 22, 0.14);
    border-radius: 999px;
    background: #fff7ed;
    color: var(--landing-accent-dark, var(--base-color-700));
    padding: 0.35rem 0.65rem;
    font-size: 0.7rem;
    font-weight: 800;
}

.book-chip-muted {
    border-color: rgba(100, 116, 139, 0.14);
    background: #f1f5f9;
    color: #64748b;
}

.book-author,
.blog-date {
    color: var(--landing-muted);
}

.book-price {
    color: var(--landing-accent-dark, var(--base-color-700));
    font-size: 0.96rem;
    line-height: 1.25;
}

.testimonial-marquee {
    position: relative;
    overflow: hidden;
}

.testimonial-marquee::before,
.testimonial-marquee::after {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    z-index: 2;
    width: min(200px, 25vw);
    pointer-events: none;
}

.testimonial-marquee::before {
    left: 0;
    background:
        linear-gradient(90deg, rgba(248, 250, 252, 1) 0%, rgba(248, 250, 252, 0) 100%);
}

.testimonial-marquee::after {
    right: 0;
    background:
        linear-gradient(270deg, rgba(248, 250, 252, 1) 0%,  rgba(248, 250, 252, 0) 100%);
}

.testimonial-marquee-track {
    display: flex;
    width: max-content;
    animation: testimonialMarquee 32s linear infinite;
    will-change: transform;
}

.testimonial-marquee:hover .testimonial-marquee-track {
    animation-play-state: paused;
}

.testimonial-marquee-group {
    display: flex;
    flex-shrink: 0;
    gap: 1.5rem;
}

.testimonial-message {
    flex: 1;
    display: -webkit-box;
    overflow: hidden;
    -webkit-line-clamp: 4;
    line-clamp: 4;
    -webkit-box-orient: vertical;
}

.img-fluid object-fit-cover w-100 h-100 {
    width: 54px;
    height: 54px;
    min-width: 54px;
    border: 2px solid rgba(249, 115, 22, 0.24);
    border-radius: 50%;
    object-fit: cover;
}

.testimonial-name {
    color: var(--landing-ink);
    font-size: 0.95rem;
}

.blog-card {
    display: flex;
    flex-direction: column;
}

.blog-image-wrapper {
    position: relative;
    aspect-ratio: 16 / 10;
}

.blog-card-body {
    flex: 1;
}

.blog-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    border-radius: 999px;
    background: rgba(15, 23, 42, 0.78);
    color: #ffffff;
    padding: 0.45rem 0.7rem;
    font-size: 0.78rem;
    font-weight: 800;
    backdrop-filter: blur(8px);
}

.faq-answer {
    animation: slideDown 0.25s ease;
}

.faq-answer-content :deep(p:last-child) {
    margin-bottom: 0;
}

.contact-heading {
    font-size: 3rem;
    line-height: 1.12;
    letter-spacing: 0;
}

.contact-stack {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.contact-link {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    min-height: 58px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    font-weight: 800;
    padding: 0.85rem 1rem;
    backdrop-filter: blur(8px);
    transition: background 0.2s ease, transform 0.2s ease;
}

.contact-link span {
    min-width: 0;
    overflow-wrap: anywhere;
}

.contact-link:hover,
.contact-social:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.18);
    transform: translateY(-2px);
}

.contact-social {
    width: 50px;
    height: 50px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    transition: background 0.2s ease, transform 0.2s ease;
}

.bg-animated-dots {
    position: relative;
    background-color: #ffffff;
    overflow: hidden;
}

.dot-base {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(#e2e8f0 3px, transparent 3px);
    background-size: 26px 26px;
    background-position: top center;
    z-index: 0;
}

.dot-light-sweep {
    position: absolute;
    inset: 0;
    z-index: 0;
    background: linear-gradient(-45deg, transparent 35%, #fb923c 50%, transparent 65%);
    background-size: 300% 300%;
    animation: dotSweep 6s linear infinite;
    -webkit-mask-image: radial-gradient(#000 3px, transparent 3px);
    -webkit-mask-size: 26px 26px;
    -webkit-mask-position: top center;
    mask-image: radial-gradient(#000 3px, transparent 3px);
    mask-size: 26px 26px;
    mask-position: top center;
}

.dot-fade-mask {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(255, 255, 255, 1) 5%, rgba(255, 255, 255, 0) 100%);
    z-index: 0;
    pointer-events: none;
}

@keyframes dotSweep {
    0% {
        background-position: 100% 100%;
    }

    100% {
        background-position: 0% 0%;
    }
}

@keyframes landingFadeUp {
    from {
        opacity: 0;
        transform: translateY(18px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bookModalFade {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes bookModalRise {
    from {
        opacity: 0;
        transform: translateY(16px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes testimonialMarquee {
    from {
        transform: translateX(0);
    }

    to {
        transform: translateX(-50%);
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.object-fit-cover {
    object-fit: cover;
}

@media (max-width: 1199.98px) {

    .book-slide-content {
        min-height: 260px;
    }
}

@media (max-width: 991.98px) {
    .landing-section {
        padding: 5.5rem 0;
    }

    .book-modal-panel,
    .book-modal-grid,
    .service-modal-panel,
    .service-modal-grid {
        max-height: none;
    }

    .book-modal-grid,
    .service-modal-grid {
        grid-template-columns: 1fr;
    }

    .book-modal-media {
        min-height: auto;
        border-right: 0;
        border-bottom: 1px solid rgba(226, 232, 240, 0.9);
    }

    .service-modal-media {
        border-right: 0;
        border-bottom: 1px solid rgba(226, 232, 240, 0.9);
    }

    .service-modal-image-frame {
        max-width: 560px;
    }

    .book-modal-image-frame {
        max-height: 430px;
    }

    .book-modal-content,
    .service-modal-content {
        max-height: none;
    }
}

@media (max-width: 767.98px) {
    .landing-section {
        padding: 4.5rem 0;
    }

    .section-heading {
        font-size: 2.1rem;
    }

    .contact-heading {
        font-size: 2.25rem;
    }

    .service-note {
        flex-direction: column;
    }

    .book-slider-head {
        align-items: flex-start;
        flex-direction: column;
    }

    .book-slider-controls {
        width: 100%;
        justify-content: flex-end;
    }

    .testimonial-card {
        flex-basis: 300px;
    }

    .testimonial-marquee::before,
    .testimonial-marquee::after {
        width: 78px;
    }
}

@media (max-width: 575.98px) {
    .book-modal-backdrop {
        align-items: stretch;
        padding: 0;
    }

    .service-bootstrap-modal .modal-dialog {
        max-width: none;
        margin: 0;
    }

    .book-modal-panel,
    .service-modal-panel {
        width: 100%;
        min-height: 100vh;
        border-radius: 0;
    }

    .book-modal-close,
    .service-modal-close {
        top: 0.85rem;
        right: 0.85rem;
    }

    .book-modal-media,
    .service-modal-media {
        padding: 4.25rem 1rem 1rem;
    }

    .book-modal-content,
    .service-modal-content {
        padding: 1.25rem;
    }

    .book-modal-title,
    .service-modal-title {
        font-size: 1.8rem;
    }

    .book-modal-meta-grid,
    .service-modal-highlight-grid {
        grid-template-columns: 1fr;
    }

    .book-modal-actions .btn,
    .service-modal-actions .btn {
        width: 100%;
    }

    .testimonial-card {
        flex-basis: 280px;
        min-height: 250px;
        padding: 1.25rem;
    }

    .testimonial-marquee-track {
        animation-duration: 26s;
    }

    .book-swiper {
        margin-right: -1rem;
        padding-right: 1rem;
    }

    .book-slide-cover {
        aspect-ratio: 16 / 10;
    }

    .book-slide-content {
        min-height: 250px;
    }

    .book-slide-footer {
        align-items: stretch;
        flex-direction: column;
    }

    .service-card-top {
        flex-direction: column;
    }

    .service-price {
        text-align: left;
    }
}

@media (prefers-reduced-motion: reduce) {

    .landing-reveal,
    .faq-answer,
    .book-modal-backdrop,
    .book-modal-panel,
    .testimonial-marquee-track,
    .dot-light-sweep,
    .shake-icon {
        opacity: 1;
        transform: none;
        animation: none;
    }

    .service-card,
    .book-slide-card,
    .blog-card,
    .testimonial-card,
    .book-modal-close,
    .book-modal-trigger,
    .book-slider-btn,
    .contact-link,
    .contact-social,
    .service-image,
    .book-image,
    .blog-image {
        transition: none;
    }
}

/* Aturan untuk Mobile (1 Kolom - default col-12) */
.card-item:first-child .inner-card {
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
}

.card-item:last-child .inner-card {
    border-bottom-left-radius: 1rem;
    border-bottom-right-radius: 1rem;
}

@media (min-width: 576px) {
    .card-item .inner-card {
        border-radius: 0;
    }

    .card-item:first-child .inner-card {
        border-top-left-radius: 1rem;
        border-top-right-radius: 0;
    }

    .card-item:nth-child(2) .inner-card {
        border-top-right-radius: 1rem;
    }

    .card-item:nth-last-child(2) .inner-card {
        border-bottom-left-radius: 1rem;
    }

    .card-item:last-child .inner-card {
        border-bottom-right-radius: 1rem;
        border-bottom-left-radius: 0;
    }
}

.shake-icon {
    animation: sequenceShake 10s infinite;
    transform-origin: center;
}

@keyframes sequenceShake {
    0% {
        transform: rotate(0deg);
    }

    1.5% {
        transform: rotate(-10deg) scale(1.1);
    }

    3% {
        transform: rotate(10deg) scale(1.1);
    }

    4.5% {
        transform: rotate(-10deg) scale(1.1);
    }

    6% {
        transform: rotate(10deg) scale(1.1);
    }

    7.5% {
        transform: rotate(0deg) scale(1);
    }

    100% {
        transform: rotate(0deg);
    }
}
</style>
