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
    
                        <a href="/" class="d-flex align-items-center gap-4">
                            <img :alt="`Logo ${setting.site_title}`" :src="`/storage/${setting.site_logo}`" class="h-50px h-md-60px" />
                            <!-- <span style="font-weight: 800;" class="lh-sm mw-150px text-uppercase fs-3 text-myprimary">{{ setting.site_title }}</span> -->
                        </a>

                        <div class="d-none d-lg-flex align-items-center gap-10 position-absolute top-50 start-50 translate-middle">
                            <a href="/"
                                @click.prevent="goHome"
                                :class="desktopHomeClass"
                                class="fs-5">
                                Beranda
                            </a>
                            <a href="/books" 
                                :class="desktopRouteClass('/books')"
                                class="fs-5">
                                Buku
                            </a>
                            <a href="/#services"
                                @click.prevent="navigateToSection('services')"
                                :class="desktopSectionClass('services')"
                                class="fs-5">
                                Layanan
                            </a>
                            <a href="/#testimonials"
                                @click.prevent="navigateToSection('testimonials')"
                                :class="desktopSectionClass('testimonials')"
                                class="fs-5">
                                Testimoni
                            </a>
                            <a href="/blogs" 
                                :class="desktopRouteClass('/blogs')"
                                class="fs-5">
                                Blog
                            </a>
                            <a href="/#faqs"
                                @click.prevent="navigateToSection('faqs')"
                                :class="desktopSectionClass('faqs')"
                                class="fs-5">
                                FAQ
                            </a>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <a href="/#contact"
                                @click.prevent="navigateToSection('contact')"
                                class="d-none d-lg-flex align-items-center gap-1 fs-5 rounded-3 btn btn-hover-icon btn-myprimary-filled fw-bolder">
                                <span>Kirim Layanan</span>
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
                            <img :alt="`Logo ${setting.site_title}`" :src="`/storage/${setting.site_logo}`" class="h-50px h-md-60px" />
                            <!-- <img :alt="`Logo ${setting.site_title}`" :src="`/storage/${setting.site_logo}`" class="h-35px h-md-45px" /> -->
                            <!-- <span style="font-weight: 800;" class="lh-sm mw-150px text-uppercase fs-3 text-myprimary">{{ setting.site_title }}</span> -->
                        </div>
                        <button @click="isDrawerOpen = false" class="btn btn-icon btn-mytertiary-ghost rounded-circle me-n3">
                            <i class="bi bi-x-lg fs-3"></i>
                        </button>
                    </div>

                    <div class="px-5 py-6 d-flex flex-column gap-2 overflow-auto flex-grow-1">
                        <a href="/"
                            @click.prevent="goHome"
                            :class="drawerHomeClass"
                            class="text-start fs-5 px-7 py-4 btn btn-sm rounded-3">
                            Beranda
                        </a>
                        <a href="/books"
                            @click="isDrawerOpen = false"
                            :class="drawerRouteClass('/books')"
                            class="text-start fs-5 px-7 py-4 btn btn-sm rounded-3">
                            Buku
                        </a>
                        <a href="/#services"
                            @click.prevent="navigateToSection('services')"
                            :class="drawerSectionClass('services')"
                            class="text-start fs-5 px-7 py-4 btn btn-sm rounded-3">
                            Layanan
                        </a>
                        <a href="/#testimonials"
                            @click.prevent="navigateToSection('testimonials')"
                            :class="drawerSectionClass('testimonials')"
                            class="text-start fs-5 px-7 py-4 btn btn-sm rounded-3">
                            Testimoni
                        </a>
                        <a href="/blogs"
                            @click="isDrawerOpen = false"
                            :class="drawerRouteClass('/blogs')"
                            class="text-start fs-5 px-7 py-4 btn btn-sm rounded-3">
                            Blog
                        </a>
                        <a href="/#faqs"
                            @click.prevent="navigateToSection('faqs')"
                            :class="drawerSectionClass('faqs')"
                            class="text-start fs-5 px-7 py-4 btn btn-sm rounded-3">
                            FAQ
                        </a>
                    </div>
                    <div class="px-5 py-6 mt-auto">
                        <a href="/#contact"
                            @click.prevent="navigateToSection('contact')"
                            class="d-flex align-items-center justify-content-between gap-1 fs-5 rounded-3 px-7 py-4 btn btn-sm btn-hover-icon btn-myprimary-filled fw-bolder">
                            <span>Kirim Layanan</span>
                            <i class="ri-arrow-right-up-line fw-bold fs-2 me-n3"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex-grow-1">
                <slot />
            </div>

            <footer class="w-100 flex-shrink-0 text-center py-6 text-gray-500 fs-6 fw-semibold bg-white border-top border-gray-300"
                :style="{ marginTop: footerMarginTop }">
                © {{ new Date().getFullYear() }} <span class="fw-bolder text-gray-700">{{ setting.site_title }}</span> • All Rights Reserved
            </footer>

        </div>
    </main>
</template>

<script>
    import { onMounted, onUnmounted, onUpdated, computed, nextTick, ref, watch } from "vue";
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
            const activeSection = ref('');
            const sectionTargets = ['services', 'testimonials', 'faqs', 'contact'];
            let sectionScrollTimer = null;

            const currentPath = computed(() => {
                const url = page.url || '/';
                const path = url.split('#')[0].split('?')[0];

                return path || '/';
            });

            const isHomePage = computed(() => currentPath.value === '/');
            const isHomeNavActive = computed(() => isHomePage.value && !activeSection.value);
            const desktopHomeClass = computed(() => {
                return isHomeNavActive.value
                    ? 'btn-link-myprimary fw-bolder'
                    : 'btn-link-mytertiary-light fw-semibold';
            });
            const drawerHomeClass = computed(() => {
                return isHomeNavActive.value
                    ? 'btn-myprimary-tinted fw-bolder'
                    : 'btn-mytertiary-ghostest fw-bold';
            });

            const isSectionActive = (sectionId) => {
                return isHomePage.value && activeSection.value === sectionId;
            };

            const desktopSectionClass = (sectionId) => {
                return isSectionActive(sectionId)
                    ? 'btn-link-myprimary fw-bolder'
                    : 'btn-link-mytertiary-light fw-semibold';
            };

            const drawerSectionClass = (sectionId) => {
                return isSectionActive(sectionId)
                    ? 'btn-myprimary-tinted fw-bolder'
                    : 'btn-mytertiary-ghostest fw-bold';
            };

            const desktopRouteClass = (path) => {
                return currentPath.value.startsWith(path)
                    ? 'btn-link-myprimary fw-bolder'
                    : 'btn-link-mytertiary-light fw-semibold';
            };

            const drawerRouteClass = (path) => {
                return currentPath.value.startsWith(path)
                    ? 'btn-myprimary-tinted fw-bolder'
                    : 'btn-mytertiary-ghostest fw-bold';
            };

            const getNavigationOffset = () => {
                const navigation = document.getElementById('navigation');

                return (navigation?.offsetHeight || 0) + 18;
            };

            const updateActiveSection = () => {
                if (!isHomePage.value) {
                    activeSection.value = '';
                    return;
                }

                const activationLine = getNavigationOffset() + Math.min(window.innerHeight * 0.32, 220);
                const visibleSection = sectionTargets.find((sectionId) => {
                    const section = document.getElementById(sectionId);

                    if (!section) {
                        return false;
                    }

                    const rect = section.getBoundingClientRect();

                    return rect.top <= activationLine && rect.bottom > activationLine;
                });

                activeSection.value = visibleSection || '';
            };

            const handleScroll = () => {
                isSticky.value = window.scrollY > (window.innerHeight * 0.25);
                updateActiveSection();
            };

            const scrollToSection = (sectionId, behavior = 'smooth') => {
                const section = document.getElementById(sectionId);

                if (!section) {
                    activeSection.value = '';
                    return;
                }

                const targetTop = section.getBoundingClientRect().top + window.scrollY - getNavigationOffset();

                window.scrollTo({
                    top: Math.max(0, targetTop),
                    behavior,
                });

                activeSection.value = sectionId;
            };

            const scheduleSectionScroll = (sectionId, delay = 0) => {
                if (sectionScrollTimer) {
                    clearTimeout(sectionScrollTimer);
                }

                nextTick(() => {
                    sectionScrollTimer = window.setTimeout(() => {
                        scrollToSection(sectionId);
                    }, delay);
                });
            };

            const navigateToSection = (sectionId) => {
                isDrawerOpen.value = false;

                if (!sectionTargets.includes(sectionId)) {
                    return;
                }

                if (!isHomePage.value) {
                    router.visit('/', {
                        preserveScroll: false,
                        onSuccess: () => {
                            window.scrollTo({ top: 0, behavior: 'auto' });
                            window.history.replaceState(null, '', `/#${sectionId}`);
                            scheduleSectionScroll(sectionId, 260);
                        },
                    });
                    return;
                }

                window.history.replaceState(null, '', `/#${sectionId}`);
                scheduleSectionScroll(sectionId);
            };

            const goHome = () => {
                isDrawerOpen.value = false;
                activeSection.value = '';

                if (isHomePage.value) {
                    window.history.replaceState(null, '', '/');
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    return;
                }

                router.visit('/', {
                    preserveScroll: false,
                    onSuccess: () => {
                        activeSection.value = '';
                        window.scrollTo({ top: 0, behavior: 'auto' });
                    },
                });
            };

            onMounted(() => {
                handleScroll();
                window.addEventListener('scroll', handleScroll, { passive: true });
                window.KTMenu?.init();

                const initialSection = window.location.pathname === '/'
                    ? window.location.hash.replace('#', '')
                    : '';

                if (sectionTargets.includes(initialSection)) {
                    window.scrollTo({ top: 0, behavior: 'auto' });
                    scheduleSectionScroll(initialSection, 260);
                }
            });

            onUnmounted(() => {
                window.removeEventListener('scroll', handleScroll);
                if (sectionScrollTimer) {
                    clearTimeout(sectionScrollTimer);
                }
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

            watch(currentPath, () => {
                activeSection.value = '';
                nextTick(updateActiveSection);
            });

            router.on('navigate', () => {
                isDrawerOpen.value = false; 
                isInformasiOpen.value = false;
                nextTick(updateActiveSection);
                window.KTMenu?.init();
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
                desktopHomeClass,
                drawerHomeClass,
                desktopRouteClass,
                drawerRouteClass,
                desktopSectionClass,
                drawerSectionClass,
                navigateToSection,
                goHome
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
</style>
