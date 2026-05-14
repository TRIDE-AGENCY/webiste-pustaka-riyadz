<template>
    <main
        id="kt_body"
        class="bg-light position-relative app-blank"
        data-kt-name="metronic"
        data-bs-spy="scroll"
        data-bs-target="#kt_landing_menu"
    >
        <div class="d-flex flex-column flex-root min-vh-100" id="kt_app_root">
            <div id="navigation"
                :class="[
                    'w-100 transition-all duration-500',
                    isSticky
                        ? 'bg-white fixed-top animate__animated animate__fadeInDown border-bottom border-gray-300 shadow-soft'
                        : `${navbarDefaultBg} shadow-none`
                ]"
                style="z-index: 1050;"
            >
                <div class="container px-lg-0">
                    <div class="py-6 d-flex align-items-center justify-content-between position-relative">
    
                        <a href="/" @click.prevent="navigateHome" class="d-flex align-items-center gap-4">
                            <img :alt="`Logo ${setting.site_title}`" :src="`/storage/${setting.site_logo}`" class="h-30px h-md-40px" />
                            <!-- <span style="font-weight: 800;" class="lh-sm mw-150px text-uppercase fs-3 text-myprimary">{{ setting.site_title }}</span> -->
                        </a>

                        <div class="d-none d-lg-flex align-items-center gap-10 position-absolute top-50 start-50 translate-middle">
                            <a href="/"
                                @click.prevent="navigateHome"
                                :class="isHomeActive ? 'btn-link-myprimary fw-bolder' : 'btn-link-mytertiary-light fw-semibold'"
                                class="fs-5">
                                Beranda
                            </a>
                            <a href="/books" 
                                :class="$page.url.startsWith('/books') ? 'btn-link-myprimary fw-bolder' : 'btn-link-mytertiary-light fw-semibold'"
                                class="fs-5">
                                Buku
                            </a>
                            <a href="/#services"
                                @click.prevent="navigateToSection('services')"
                                :class="isSectionActive('services') ? 'btn-link-myprimary fw-bolder' : 'btn-link-mytertiary-light fw-semibold'"
                                class="fs-5">
                                Layanan
                            </a>
                            <a href="/#testimonials"
                                @click.prevent="navigateToSection('testimonials')"
                                :class="isSectionActive('testimonials') ? 'btn-link-myprimary fw-bolder' : 'btn-link-mytertiary-light fw-semibold'"
                                class="fs-5">
                                Testimoni
                            </a>
                            <a href="/blogs" 
                                :class="$page.url.startsWith('/blogs') ? 'btn-link-myprimary fw-bolder' : 'btn-link-mytertiary-light fw-semibold'"
                                class="fs-5">
                                Blog
                            </a>
                            <a href="/#faqs"
                                @click.prevent="navigateToSection('faqs')"
                                :class="isSectionActive('faqs') ? 'btn-link-myprimary fw-bolder' : 'btn-link-mytertiary-light fw-semibold'"
                                class="fs-5">
                                FAQ
                            </a>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <a href="/#contact"
                                @click.prevent="navigateToSection('contact')"
                                :class="{ 'section-nav-cta-active': isSectionActive('contact') }"
                                class="d-none d-lg-flex align-items-center gap-1 fs-5 rounded-3 btn btn-hover-icon btn-myprimary-filled fw-bolder">
                                <span>Kirim Naskah</span>
                                <i class="ri-arrow-right-up-line fw-bold fs-2 me-n3"></i>
                            </a>
                            
                            <button @click="isDrawerOpen = true" class="btn btn-icon btn-mytertiary-ghost rounded-pill d-lg-none me-n3">
                                <i class="ri-menu-line fs-1"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div v-if="isDrawerOpen" class="fixed-top w-100 h-100" style="z-index: 2000;">
                <div @click="isDrawerOpen = false" class="position-absolute w-100 h-100 bg-dark opacity-50 transition-all"></div>
                
                <div class="position-absolute top-0 start-0 bg-white h-100 w-300px shadow-sm d-flex flex-column animate__animated animate__slideInLeft">
                    <div class="d-flex align-items-center justify-content-between px-5 py-6 border-bottom border-gray-300">
                        <div class="d-flex align-items-center gap-4">
                            <img :alt="`Logo ${setting.site_title}`" :src="`/storage/${setting.site_logo}`" class="h-30px h-md-40px" />
                            <!-- <img :alt="`Logo ${setting.site_title}`" :src="`/storage/${setting.site_logo}`" class="h-35px h-md-45px" /> -->
                            <!-- <span style="font-weight: 800;" class="lh-sm mw-150px text-uppercase fs-3 text-myprimary">{{ setting.site_title }}</span> -->
                        </div>
                        <button @click="isDrawerOpen = false" class="btn btn-icon btn-mytertiary-ghost rounded-circle me-n3">
                            <i class="bi bi-x-lg fs-3"></i>
                        </button>
                    </div>

                    <div class="px-5 py-6 d-flex flex-column gap-2 overflow-auto flex-grow-1">
                        <a href="/"
                            @click.prevent="navigateHome"
                            :class="isHomeActive ? 'btn-myprimary-tinted fw-bolder' : 'btn-mytertiary-ghostest fw-bold'"
                            class="text-start fs-5 px-7 py-4 btn btn-sm rounded-3">
                            Beranda
                        </a>
                        <a href="/books"
                            @click="isDrawerOpen = false"
                            :class="$page.url.startsWith('/books') ? 'btn-myprimary-tinted fw-bolder' : 'btn-mytertiary-ghostest fw-bold'"
                            class="text-start fs-5 px-7 py-4 btn btn-sm rounded-3">
                            Buku
                        </a>
                        <a href="/#services"
                            @click.prevent="navigateToSection('services')"
                            :class="isSectionActive('services') ? 'btn-myprimary-tinted fw-bolder' : 'btn-mytertiary-ghostest fw-bold'"
                            class="text-start fs-5 px-7 py-4 btn btn-sm rounded-3">
                            Layanan
                        </a>
                        <a href="/#testimonials"
                            @click.prevent="navigateToSection('testimonials')"
                            :class="isSectionActive('testimonials') ? 'btn-myprimary-tinted fw-bolder' : 'btn-mytertiary-ghostest fw-bold'"
                            class="text-start fs-5 px-7 py-4 btn btn-sm rounded-3">
                            Testimoni
                        </a>
                        <a href="/blogs"
                            @click="isDrawerOpen = false"
                            :class="$page.url.startsWith('/blogs') ? 'btn-myprimary-tinted fw-bolder' : 'btn-mytertiary-ghostest fw-bold'"
                            class="text-start fs-5 px-7 py-4 btn btn-sm rounded-3">
                            Blog
                        </a>
                        <a href="/#faqs"
                            @click.prevent="navigateToSection('faqs')"
                            :class="isSectionActive('faqs') ? 'btn-myprimary-tinted fw-bolder' : 'btn-mytertiary-ghostest fw-bold'"
                            class="text-start fs-5 px-7 py-4 btn btn-sm rounded-3">
                            FAQ
                        </a>
                    </div>
                    <div class="px-5 py-6 mt-auto">
                        <a href="/#contact"
                            @click.prevent="navigateToSection('contact')"
                            :class="{ 'section-nav-cta-active': isSectionActive('contact') }"
                            class="d-flex align-items-center justify-content-between gap-1 fs-5 rounded-3 px-7 py-4 btn btn-sm btn-hover-icon btn-myprimary-filled fw-bolder">
                            <span>Kirim Naskah</span>
                            <i class="ri-arrow-right-up-line fw-bold fs-2 me-n3"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex-grow-1">
                <slot />
            </div>

            <footer class="w-100 flex-shrink-0 text-center py-6 text-white fs-6 fw-semibold bg-myprimary"
                :style="{ marginTop: footerMarginTop }">
                © {{ new Date().getFullYear() }} <span class="fw-bolder text-white">{{ setting.site_title }}</span> • All Rights Reserved
            </footer>

        </div>
    </main>
</template>

<script>
    import { nextTick, onMounted, onUnmounted, onUpdated, computed, ref, watch } from "vue";
    import { Head, Link, router, usePage } from '@inertiajs/vue3';

    export default {
        components: { 
            Head,
            Link 
        },

        props: {
            setting: Object,
            navbarDefaultBg: {
                type: String,
                default: 'bg-white',
            },
            footerMarginTop: {
                type: String,
                default: '12.5rem',
            },
        },

        setup(props) {
            const page = usePage();
            const isDrawerOpen = ref(false);
            const isSticky = ref(false);
            const isInformasiOpen = ref(false);
            const activeSection = ref('home');
            const sectionIds = ['services', 'testimonials', 'faqs', 'contact'];
            const pendingSectionStorageKey = 'pustaka-riyadz-pending-section';

            const currentPath = computed(() => (page.url || '/').split(/[?#]/)[0] || '/');
            const isHomePage = computed(() => currentPath.value === '/');
            const isHomeActive = computed(() => isHomePage.value && activeSection.value === 'home');

            const prefersReducedMotion = () => window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;

            const getNavbarOffset = () => {
                const navigation = document.getElementById('navigation');

                return (navigation?.offsetHeight || 0) + 16;
            };

            const updateActiveSection = () => {
                if (!isHomePage.value) {
                    activeSection.value = 'home';
                    return;
                }

                const activationLine = getNavbarOffset() + 48;
                const currentSection = sectionIds.find((sectionId) => {
                    const element = document.getElementById(sectionId);

                    if (!element) {
                        return false;
                    }

                    const rect = element.getBoundingClientRect();

                    return rect.top <= activationLine && rect.bottom > activationLine;
                });

                activeSection.value = currentSection || 'home';
            };

            const scrollToSection = (sectionId, attempt = 0) => {
                const element = document.getElementById(sectionId);

                if (!element) {
                    if (attempt < 12) {
                        window.setTimeout(() => scrollToSection(sectionId, attempt + 1), 80);
                    }

                    return;
                }

                const top = Math.max(0, element.getBoundingClientRect().top + window.scrollY - getNavbarOffset());

                window.scrollTo({
                    top,
                    behavior: prefersReducedMotion() ? 'auto' : 'smooth',
                });

                activeSection.value = sectionId;
                window.history.replaceState(null, '', `/#${sectionId}`);
            };

            const scrollToHome = () => {
                window.scrollTo({
                    top: 0,
                    behavior: prefersReducedMotion() ? 'auto' : 'smooth',
                });

                activeSection.value = 'home';
                window.history.replaceState(null, '', '/');
            };

            const setPendingSection = (sectionId) => {
                window.sessionStorage?.setItem(pendingSectionStorageKey, sectionId);
            };

            const consumePendingSection = () => {
                const sectionId = window.sessionStorage?.getItem(pendingSectionStorageKey);

                if (sectionId) {
                    window.sessionStorage?.removeItem(pendingSectionStorageKey);
                }

                return sectionIds.includes(sectionId) ? sectionId : null;
            };

            const getHashSection = () => {
                const sectionId = window.location.hash.replace('#', '');

                return sectionIds.includes(sectionId) ? sectionId : null;
            };

            const scrollFromTopToSection = (sectionId) => {
                window.scrollTo({ top: 0, behavior: 'auto' });

                window.setTimeout(() => {
                    scrollToSection(sectionId);
                }, 120);
            };

            const handlePendingSectionScroll = () => {
                if (!isHomePage.value) {
                    return;
                }

                const targetSection = consumePendingSection() || getHashSection();

                if (targetSection) {
                    scrollFromTopToSection(targetSection);
                    return;
                }

                updateActiveSection();
            };

            const navigateHome = () => {
                isDrawerOpen.value = false;

                if (isHomePage.value) {
                    scrollToHome();
                    return;
                }

                router.visit('/', {
                    preserveScroll: false,
                });
            };

            const navigateToSection = (sectionId) => {
                isDrawerOpen.value = false;

                if (isHomePage.value) {
                    scrollToSection(sectionId);
                    return;
                }

                setPendingSection(sectionId);
                router.visit('/', {
                    preserveScroll: false,
                });
            };

            const isSectionActive = (sectionId) => {
                return isHomePage.value && activeSection.value === sectionId;
            };

            const handleScroll = () => {
                isSticky.value = window.scrollY > (window.innerHeight * 0.25);
                updateActiveSection();
            };

            const handleHashChange = () => {
                const targetSection = getHashSection();

                if (targetSection && isHomePage.value) {
                    scrollFromTopToSection(targetSection);
                }
            };

            let removeNavigateListener = null;

            onMounted(() => {
                handleScroll();
                window.addEventListener('scroll', handleScroll, { passive: true });
                window.addEventListener('hashchange', handleHashChange);
                window.KTMenu?.init();

                removeNavigateListener = router.on('navigate', () => {
                    isDrawerOpen.value = false;
                    isInformasiOpen.value = false;

                    nextTick(() => {
                        window.KTMenu?.init();
                        handleScroll();
                        handlePendingSectionScroll();
                    });
                });

                nextTick(() => {
                    handlePendingSectionScroll();
                });
            });

            onUnmounted(() => {
                window.removeEventListener('scroll', handleScroll);
                window.removeEventListener('hashchange', handleHashChange);
                removeNavigateListener?.();
            });

            onUpdated(() => {
                window.KTMenu?.init();
            });

            watch(isDrawerOpen, (val) => {
                if (val) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });

            const formattedWhatsApp = computed(() => {
                let num = props.setting.whatsapp.toString().replace(/\D/g, '');
                if (num.startsWith('62')) num = num.substring(2);
                else if (num.startsWith('0')) num = num.substring(1);
                
                const part1 = num.substring(0, 3);
                const part2 = num.substring(3, 7);
                const part3 = num.substring(7);
                
                return {
                    display: `+62 ${part1}-${part2}-${part3}`,
                    link: `https://wa.me/62${num}`
                };
            });

            return { 
                formattedWhatsApp,
                isDrawerOpen,
                isInformasiOpen,
                isSticky,
                isHomeActive,
                isSectionActive,
                navigateHome,
                navigateToSection
            };
        }
    }
</script>

<style>
    .transition-all {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fixed-top {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
    }

    @keyframes slideInLeft {
        from {
            transform: translateX(-100%);
        }
        to {
            transform: translateX(0);
        }
    }

    .animate__slideInLeft {
        animation: slideInLeft 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes fadeInDown {
        from { 
            opacity: 0; 
            transform: translateY(-40px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    .animate__fadeInDown {
        animation: fadeInDown 0.5s ease-out;
    }

    .shadow-soft {
        box-shadow: 0 10px 32px rgba(0, 0, 0, 0.04) !important; 
    }

    .section-nav-cta-active {
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.18), 0 10px 32px rgba(249, 115, 22, 0.16) !important;
    }
</style>
