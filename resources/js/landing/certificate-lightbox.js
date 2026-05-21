const defaultImageClasses = 'h-auto max-h-[92vh] w-auto max-w-[96vw] object-contain';
const compactImageClasses = 'h-auto max-h-[78vh] w-auto max-w-[80vw] object-contain';

export function registerCertificateLightbox(Alpine) {
    Alpine.data('certificateLightbox', () => ({
        isCertificateLightboxOpen: false,
        certificateImageSrc: '',
        certificateTitle: 'Sertifikat',
        certificateAlt: 'Sertifikat',
        certificateVariant: '',

        open(detail = {}) {
            this.certificateImageSrc = detail.src || '';
            this.certificateTitle = detail.title || 'Sertifikat';
            this.certificateAlt = detail.alt || this.certificateTitle;
            this.certificateVariant = detail.variant || '';
            this.isCertificateLightboxOpen = true;
            document.body.classList.add('overflow-hidden');
        },

        close() {
            this.isCertificateLightboxOpen = false;
            this.certificateImageSrc = '';
            this.certificateTitle = 'Sertifikat';
            this.certificateAlt = 'Sertifikat';
            this.certificateVariant = '';
            document.body.classList.remove('overflow-hidden');
        },

        certificateImageClasses() {
            return this.certificateVariant === 'compact' ? compactImageClasses : defaultImageClasses;
        },
    }));
}
