export function registerTestimonialsCarousel(Alpine) {
    Alpine.data('testimonialsCarousel', () => ({
        activeIndex: 0,
        cardStep: 0,
        transitionEnabled: true,

        get totalCards() {
            return this.$refs.track ? this.$refs.track.children.length : 0;
        },

        init() {
            this.measure();
        },

        measure() {
            this.$nextTick(() => {
                const card = this.$refs.card;
                const track = this.$refs.track;

                if (!card || !track) {
                    this.cardStep = 0;
                    return;
                }

                const trackStyle = window.getComputedStyle(track);
                const gap = parseFloat(trackStyle.columnGap || trackStyle.gap || 0);
                this.cardStep = card.getBoundingClientRect().width + gap;

                if (this.activeIndex > this.maxIndex()) {
                    this.activeIndex = this.maxIndex();
                }
            });
        },

        maxIndex() {
            return Math.max(0, this.totalCards - 1);
        },

        cardPosition(index) {
            return index - this.activeIndex;
        },

        cardTone(index) {
            const position = this.cardPosition(index);

            if (position === 0) {
                return 'bg-[#1839a8] text-white opacity-100 border-transparent';
            }

            if (position === 1) {
                return 'bg-white text-black opacity-100 border-transparent';
            }

            if (position === 2) {
                return 'bg-white/65 text-[#939393] opacity-80 border-slate-200 shadow-[0_8px_18px_rgba(15,23,42,0.12)]';
            }

            return 'bg-white/0 text-[#939393] opacity-0 shadow-none pointer-events-none border-transparent';
        },

        next() {
            if (this.activeIndex >= this.maxIndex()) {
                return;
            }

            this.transitionEnabled = true;
            this.activeIndex += 1;
        },

        previous() {
            if (this.activeIndex <= 0) {
                return;
            }

            this.transitionEnabled = true;
            this.activeIndex -= 1;
        },
    }));
}
