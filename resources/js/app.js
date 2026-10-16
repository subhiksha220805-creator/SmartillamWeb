document.querySelectorAll('[data-curtain-motion]').forEach((stage) => {
    const slider = stage.parentElement.querySelector('.curtain-motion__slider');

    if (!slider) {
        return;
    }

    const updateCurtainOpening = () => {
        stage.style.setProperty('--curtain-open', `${slider.value}%`);
    };

    slider.addEventListener('input', updateCurtainOpening);
    updateCurtainOpening();
});

document.querySelectorAll('[data-door-model]').forEach((button) => {
    button.addEventListener('click', () => {
        const modelGroup = button.parentElement;
        const selectedModelLabel = document.querySelector('[data-selected-door-model]');
        const selectedModelImage = document.querySelector('[data-selected-door-model-image]');

        modelGroup.querySelectorAll('[data-door-model]').forEach((modelButton) => {
            const isSelected = modelButton === button;

            modelButton.classList.toggle('active', isSelected);
            modelButton.setAttribute('aria-pressed', String(isSelected));
        });

        if (selectedModelLabel) {
            selectedModelLabel.textContent = button.dataset.doorModel;
        }

        if (selectedModelImage && button.dataset.modelImage) {
            selectedModelImage.src = button.dataset.modelImage;
            selectedModelImage.alt = `${button.dataset.doorModel} smart door lock`;
        }
    });
});

document.querySelectorAll('[data-door-model-step]').forEach((button) => {
    button.addEventListener('click', () => {
        const modelSection = button.closest('.door-models');
        const modelButtons = [...(modelSection?.querySelectorAll('[data-door-model]') ?? [])];

        if (modelButtons.length === 0) {
            return;
        }

        const selectedIndex = modelButtons.findIndex((modelButton) => modelButton.getAttribute('aria-pressed') === 'true');
        const currentIndex = selectedIndex >= 0 ? selectedIndex : 0;
        const nextIndex = (currentIndex + Number(button.dataset.doorModelStep) + modelButtons.length) % modelButtons.length;

        modelButtons[nextIndex].click();
    });
});

document.querySelectorAll('[data-home-demo]').forEach((demo) => {
    const roomButtons = [...demo.querySelectorAll('[data-demo-room]')];
    const houseImage = demo.querySelector('[data-demo-house]');
    const countLabel = demo.querySelector('[data-demo-count]');
    const moodLabel = demo.querySelector('[data-demo-mood]');
    const masterButton = demo.querySelector('[data-demo-master]');
    const statusLabel = demo.querySelector('[data-demo-status]');
    const rooms = ['living', 'kitchen', 'bedroom', 'parking'];
    const images = {
        '': 'house-unlit.png',
        living: 'living-room-lit.webp',
        kitchen: 'kitchen-lit.webp',
        bedroom: 'house-lit.webp',
        parking: 'parking-lit.webp',
        'living+kitchen': 'living-kitchen-lit.webp',
        'living+bedroom': 'living-bedroom-lit.webp',
        'living+parking': 'living-parking-lit.webp',
        'kitchen+bedroom': 'kitchen-bedroom-lit.png',
        'kitchen+parking': 'kitchen-parking-lit.webp',
        'bedroom+parking': 'bedroom-parking-lit.png',
        'living+kitchen+bedroom': 'living-kitchen-bedroom-lit.png',
        'living+kitchen+parking': 'living-kitchen-parking-lit.webp',
        'living+bedroom+parking': 'living-bedroom-parking-lit.webp',
        'kitchen+bedroom+parking': 'kitchen-bedroom-parking-lit.webp',
        'living+kitchen+bedroom+parking': 'house-all-lights-on.webp',
    };
    const roomNames = {
        living: 'living room',
        kitchen: 'kitchen',
        bedroom: 'bedroom',
        parking: 'car parking',
    };

    if (!houseImage || !masterButton) {
        return;
    }

    const refreshDemo = () => {
        const activeRooms = roomButtons
            .filter((button) => button.getAttribute('aria-pressed') === 'true')
            .map((button) => button.dataset.demoRoom);
        const imageKey = rooms.filter((room) => activeRooms.includes(room)).join('+');
        const lightCount = activeRooms.length;
        const mood = lightCount === 0 ? 'Quiet & restful' : lightCount === rooms.length ? 'Bright & welcoming' : 'Cozy evening';
        const imageName = images[imageKey];
        const description = activeRooms.length === 0
            ? 'all room lights off'
            : `${activeRooms.map((room) => roomNames[room]).join(', ')} ${activeRooms.length === 1 ? 'light is' : 'lights are'} on`;

        roomButtons.forEach((button) => {
            const isOn = button.getAttribute('aria-pressed') === 'true';

            button.querySelector('small').textContent = isOn ? 'On' : 'Off';
        });

        countLabel.textContent = String(lightCount);
        moodLabel.textContent = mood;
        masterButton.textContent = lightCount === rooms.length ? 'Turn all lights off' : 'Turn all lights on';
        houseImage.src = `${demo.dataset.demoImageBase}/${imageName}`;
        houseImage.alt = `Modern home with ${description}`;
        statusLabel.textContent = `${lightCount} of 4 lights on · ${mood}`;
    };

    roomButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const isOn = button.getAttribute('aria-pressed') === 'true';

            button.setAttribute('aria-pressed', String(!isOn));
            refreshDemo();
        });
    });

    masterButton.addEventListener('click', () => {
        const allOn = roomButtons.every((button) => button.getAttribute('aria-pressed') === 'true');

        roomButtons.forEach((button) => {
            button.setAttribute('aria-pressed', String(!allOn));
        });
        refreshDemo();
    });

    refreshDemo();
    demo.classList.add('is-ready');
    demo.parentElement.classList.add('home-demo-live-ready');
});

document.querySelectorAll('[data-cctv-model]').forEach((button) => {
    button.addEventListener('click', () => {
        const modelGroup = button.parentElement;
        const selectedModelLabel = document.querySelector('[data-selected-cctv-model]');
        const selectedModelImage = document.querySelector('[data-selected-cctv-model-image]');

        modelGroup.querySelectorAll('[data-cctv-model]').forEach((modelButton) => {
            const isSelected = modelButton === button;

            modelButton.classList.toggle('active', isSelected);
            modelButton.setAttribute('aria-pressed', String(isSelected));
        });

        if (selectedModelLabel) {
            selectedModelLabel.textContent = button.dataset.cctvModel;
        }

        if (selectedModelImage && button.dataset.modelImage) {
            selectedModelImage.src = button.dataset.modelImage;
            selectedModelImage.alt = `${button.dataset.cctvModel} CCTV camera`;
        }
    });
});

document.querySelectorAll('[data-gate-model]').forEach((button) => {
    button.addEventListener('click', () => {
        const modelGroup = button.parentElement;
        const modelSection = button.closest('.swing-gate-models');
        const selectedModelLabel = modelSection?.querySelector('[data-selected-gate-model]');
        const selectedModelImage = modelSection?.querySelector('[data-selected-gate-model-image]');

        modelGroup.querySelectorAll('[data-gate-model]').forEach((modelButton) => {
            const isSelected = modelButton === button;

            modelButton.classList.toggle('active', isSelected);
            modelButton.setAttribute('aria-pressed', String(isSelected));
        });

        if (selectedModelLabel) {
            selectedModelLabel.textContent = button.dataset.gateModel;
        }

        if (selectedModelImage && button.dataset.modelImage) {
            selectedModelImage.src = button.dataset.modelImage;
            selectedModelImage.alt = `${button.dataset.gateModel} swing gate motor`;
        }
    });
});

document.querySelectorAll('[data-gate-model-step]').forEach((button) => {
    button.addEventListener('click', () => {
        const modelSection = button.closest('.swing-gate-models');
        const modelButtons = [...(modelSection?.querySelectorAll('[data-gate-model]') ?? [])];

        if (modelButtons.length === 0) {
            return;
        }

        const selectedIndex = modelButtons.findIndex((modelButton) => modelButton.getAttribute('aria-pressed') === 'true');
        const currentIndex = selectedIndex >= 0 ? selectedIndex : 0;
        const nextIndex = (currentIndex + Number(button.dataset.gateModelStep) + modelButtons.length) % modelButtons.length;

        modelButtons[nextIndex].click();
    });
});

document.querySelectorAll('[data-feature-image]').forEach((categoryButton) => {
    categoryButton.addEventListener('click', () => {
        const featureLink = document.querySelector('[data-product-feature]');
        const featureImage = featureLink?.querySelector('[data-product-feature-image]');

        if (!featureLink || !featureImage) {
            return;
        }

        featureImage.src = categoryButton.dataset.featureImage;
        featureImage.alt = categoryButton.dataset.featureAlt;
        featureLink.href = categoryButton.dataset.featureUrl;
        featureLink.setAttribute('aria-label', categoryButton.dataset.featureLabel);
    });
});

document.querySelectorAll('[data-blog-topic]').forEach((button) => {
    button.addEventListener('click', () => {
        const selectedTopic = button.dataset.blogTopic;
        const topicButtons = document.querySelectorAll('[data-blog-topic]');
        const articleCards = document.querySelectorAll('.blog-article-card');
        const emptyState = document.querySelector('.blog-empty-state');
        let visibleArticleCount = 0;

        topicButtons.forEach((topicButton) => {
            const isSelected = topicButton === button;

            topicButton.classList.toggle('active', isSelected);
            topicButton.setAttribute('aria-pressed', String(isSelected));
        });

        articleCards.forEach((articleCard) => {
            const isVisible = selectedTopic === 'all' || articleCard.dataset.articleTopic === selectedTopic;

            articleCard.hidden = !isVisible;
            visibleArticleCount += Number(isVisible);
        });

        if (emptyState) {
            emptyState.hidden = visibleArticleCount > 0;
        }
    });
});

document.querySelectorAll('[data-newsletter-form]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const email = new FormData(form).get('email');
        const subject = encodeURIComponent('Subscribe to Smart Illam Weekly Intelligence');
        const body = encodeURIComponent(`Please add ${email} to the Smart Illam newsletter.`);

        window.location.href = `mailto:info@smartillam.in?subject=${subject}&body=${body}`;
    });
});

document.querySelectorAll('[data-service-quote]').forEach((form) => {
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const notice = form.parentElement.querySelector('[data-quote-notice]');
        const submitButton = form.querySelector('button[type="submit"]');

        if (!notice || !submitButton) {
            return;
        }

        submitButton.disabled = true;
        notice.classList.remove('is-error');
        notice.textContent = 'Sending your request…';
        notice.hidden = false;

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });
            const result = await response.json().catch(() => ({}));

            if (!response.ok) {
                const firstValidationError = Object.values(result.errors ?? {}).flat()[0];

                throw new Error(firstValidationError ?? result.message ?? 'We could not send your request. Please try again.');
            }

            notice.textContent = result.message ?? 'Your quote request has been sent successfully.';
            form.reset();
        } catch (error) {
            notice.classList.add('is-error');
            notice.textContent = error.message;
        } finally {
            submitButton.disabled = false;
        }
    });
});

document.querySelectorAll('input[name="phone"]').forEach((input) => {
    input.addEventListener('input', () => {
        input.value = input.value.replace(/\D/g, '').slice(0, Number(input.maxLength) || 15);
    });
});

const brochureModal = document.querySelector('[data-brochure-modal]');
const brochureOpenButton = document.querySelector('[data-brochure-open]');
const brochureCloseButtons = document.querySelectorAll('[data-brochure-close]');
const brochureDialog = brochureModal?.querySelector('[role="dialog"]');

if (brochureModal && brochureOpenButton && brochureDialog) {
    const closeBrochureModal = () => {
        brochureModal.hidden = true;
        document.body.classList.remove('has-brochure-modal');
        brochureOpenButton.focus();
    };

    brochureOpenButton.addEventListener('click', () => {
        brochureModal.hidden = false;
        document.body.classList.add('has-brochure-modal');
        brochureDialog.focus();
    });

    brochureCloseButtons.forEach((button) => {
        button.addEventListener('click', closeBrochureModal);
    });

    brochureModal.addEventListener('click', (event) => {
        if (event.target === brochureModal) {
            closeBrochureModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !brochureModal.hidden) {
            closeBrochureModal();
        }
    });
}

const adminPageTabs = [...document.querySelectorAll('[data-admin-page-tab]')];

if (adminPageTabs.length > 0) {
    const pagePanels = [...document.querySelectorAll('[data-admin-page-panel]')];
    const selectedPageInput = document.querySelector('[data-admin-selected-page]');
    const previewChoiceSelect = document.querySelector('[data-admin-preview-choice]');
    const previewFrame = document.querySelector('[data-admin-preview-frame]');
    const previewLink = document.querySelector('[data-admin-preview-link]');
    let previewFrameScrollTop = 0;

    const getPreviewUrl = (url) => {
        const parsedUrl = new URL(url, window.location.href);
        parsedUrl.searchParams.set('cms_preview', '1');

        return parsedUrl.toString();
    };

    previewFrame?.addEventListener('load', () => {
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                previewFrame.contentWindow?.scrollTo(0, previewFrameScrollTop);
            });
        });
    });

    const setPreviewChoices = (tab) => {
        if (!previewChoiceSelect || !previewFrame || !previewLink) {
            return;
        }

        const choices = JSON.parse(tab.dataset.adminPreviewOptions || '[]');
        previewChoiceSelect.replaceChildren(...choices.map((choice) => {
            const option = document.createElement('option');
            option.value = choice.url;
            option.textContent = choice.label;

            return option;
        }));

        const previewUrl = choices[0]?.url;

        if (previewUrl) {
            previewChoiceSelect.value = previewUrl;
            previewFrame.src = getPreviewUrl(previewUrl);
            previewLink.href = getPreviewUrl(previewUrl);
        }
    };

    previewChoiceSelect?.addEventListener('change', () => {
        if (previewFrame && previewLink) {
            previewFrameScrollTop = previewFrame.contentWindow?.scrollY ?? 0;
            previewFrame.src = getPreviewUrl(previewChoiceSelect.value);
            previewLink.href = getPreviewUrl(previewChoiceSelect.value);
        }
    });

    adminPageTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const selectedPage = tab.dataset.adminPageTab;

            adminPageTabs.forEach((pageTab) => {
                const isSelected = pageTab === tab;

                pageTab.classList.toggle('is-active', isSelected);
                pageTab.setAttribute('aria-selected', String(isSelected));
            });

            pagePanels.forEach((panel) => {
                const isSelected = panel.dataset.adminPagePanel === selectedPage;

                panel.hidden = !isSelected;
                const fieldset = panel.querySelector('.admin-page-fieldset');

                if (fieldset) {
                    fieldset.disabled = !isSelected;
                }
            });

            if (selectedPageInput) {
                selectedPageInput.value = selectedPage;
            }

            setPreviewChoices(tab);

            const pageUrl = new URL(window.location.href);
            pageUrl.searchParams.set('page', selectedPage);
            window.history.replaceState({}, '', pageUrl);
        });
    });
}

document.querySelectorAll('.admin-content-form').forEach((form) => {
    let previewTimer;
    let previewImageData = new Map();
    let previewRequest = 0;

    const updateLivePreview = (changedField, imageData = null) => {
        const previewFrame = document.querySelector('[data-admin-preview-frame]');
        const selectedPage = form.querySelector('[data-admin-selected-page]')?.value;

        if (!previewFrame || !selectedPage) {
            return;
        }

        window.clearTimeout(previewTimer);
        previewTimer = window.setTimeout(async () => {
            const field = changedField?.closest('.admin-field');
            const fieldIndex = field?.dataset.adminFieldIndex;
            const formData = new FormData();

            formData.append('page', selectedPage);

            if (field && field.dataset.adminFieldType !== 'image' && changedField?.matches('[data-admin-content-input]')) {
                formData.append(`content[${fieldIndex}]`, changedField.value);
                const clearInput = field.querySelector('.admin-clear-field input');

                if (clearInput?.checked) {
                    formData.append(`clear[${fieldIndex}]`, '1');
                }
            }

            if (field && field.dataset.adminFieldType !== 'image' && changedField?.matches('.admin-clear-field input')) {
                formData.append(`content[${fieldIndex}]`, field.querySelector('[data-admin-content-input]')?.value ?? '');

                if (changedField.checked) {
                    formData.append(`clear[${fieldIndex}]`, '1');
                }
            }

            if (field?.dataset.adminFieldType === 'image') {
                const clearInput = field.querySelector('.admin-clear-field input');
                const imageUrlInput = field.querySelector('[data-admin-image-url]');

                if (changedField?.matches('[data-admin-image-url]')) {
                    if (imageUrlInput.value.trim()) {
                        previewImageData.delete(fieldIndex);
                    } else {
                        formData.append(`reset_images[${fieldIndex}]`, '1');
                        previewImageData.delete(fieldIndex);
                    }
                } else if (changedField?.matches('.admin-clear-field input')) {
                    if (changedField.checked) {
                        formData.append(`clear_images[${fieldIndex}]`, '1');
                    } else {
                        formData.append(`reset_images[${fieldIndex}]`, '1');
                    }
                } else if (imageData) {
                    previewImageData.set(fieldIndex, imageData);
                }

                if (clearInput?.checked) {
                    formData.append(`clear_images[${fieldIndex}]`, '1');
                } else if (previewImageData.has(fieldIndex)) {
                    formData.append(`image_data[${fieldIndex}]`, previewImageData.get(fieldIndex));
                } else if (imageUrlInput?.value.trim()) {
                    formData.append(`image_urls[${fieldIndex}]`, imageUrlInput.value.trim());
                }
            }

            const csrfToken = form.querySelector('input[name="_token"]')?.value;

            if (csrfToken) {
                formData.append('_token', csrfToken);
            }

            const requestId = ++previewRequest;
            const currentScroll = previewFrame.contentWindow?.scrollY ?? 0;

            try {
                const response = await fetch(form.dataset.previewEndpoint, {
                    method: 'POST',
                    body: formData,
                    headers: { Accept: 'application/json' },
                });

                if (!response.ok || requestId !== previewRequest) {
                    return;
                }

                previewFrameScrollTop = currentScroll;
                previewFrame.src = getPreviewUrl(previewChoiceSelect.value);
            } catch {
                // Keep the last rendered preview visible if the draft update cannot be reached.
            }
        }, 350);
    };

    form.querySelectorAll('[data-admin-content-input], [data-admin-image-url]').forEach((input) => {
        input.addEventListener('input', () => updateLivePreview(input));
        input.addEventListener('change', () => updateLivePreview(input));
    });

    form.querySelectorAll('.admin-clear-field input').forEach((input) => {
        input.addEventListener('change', () => updateLivePreview(input));
    });

    form.querySelectorAll('.admin-image-controls input[type="file"]').forEach((input) => {
        input.addEventListener('change', () => {
            const file = input.files?.[0];

            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.addEventListener('load', () => updateLivePreview(input, reader.result));
            reader.readAsDataURL(file);
        });
    });

    form.querySelectorAll('[data-icon-repeater]').forEach((repeater) => {
        const contentInput = repeater.querySelector('[data-admin-content-input]');
        const rowsContainer = repeater.querySelector('[data-icon-rows]');
        const rowTemplate = repeater.querySelector('[data-icon-row-template]');
        const addButton = repeater.querySelector('[data-icon-add]');
        const fieldIndex = repeater.dataset.fieldIndex;
        const nameKey = repeater.dataset.nameKey || 'name';

        if (!contentInput || !rowsContainer || !rowTemplate || !addButton) {
            return;
        }

        const showPreview = (row, imageUrl) => {
            const preview = row.querySelector('[data-icon-preview]');
            const emptyPreview = row.querySelector('[data-icon-preview-empty]');

            if (!imageUrl) {
                preview?.remove();
                if (!emptyPreview) {
                    const empty = document.createElement('span');
                    empty.dataset.iconPreviewEmpty = '';
                    empty.setAttribute('aria-hidden', 'true');
                    empty.textContent = '✧';
                    row.querySelector('.admin-icon-row__preview')?.append(empty);
                }

                return;
            }

            emptyPreview?.remove();
            const image = preview || document.createElement('img');
            image.dataset.iconPreview = '';
            image.alt = '';
            image.src = imageUrl;

            if (!preview) {
                row.querySelector('.admin-icon-row__preview')?.append(image);
            }
        };

        const syncIconRows = () => {
            const rows = [...rowsContainer.querySelectorAll('[data-icon-row]')];
            const namedRows = rows.filter((row) => row.querySelector('[data-icon-name]')?.value.trim());
            const items = namedRows.map((row, index) => {
                const nameInput = row.querySelector('[data-icon-name]');
                const imageUrlInput = row.querySelector('[data-icon-url]');
                const uploadInput = row.querySelector('[data-icon-upload]');
                const image = uploadInput?.dataset.previewImage || imageUrlInput?.value.trim() || row.dataset.imagePath || '';

                if (uploadInput) {
                    uploadInput.name = `icon_uploads[${fieldIndex}][${index}]`;
                }
                if (imageUrlInput) {
                    imageUrlInput.name = `icon_urls[${fieldIndex}][${index}]`;
                }

                const item = { [nameKey]: nameInput?.value.trim() || '', image };
                const descriptionInput = row.querySelector('[data-icon-description]');
                if (descriptionInput) {
                    item.description = descriptionInput.value.trim();
                }
                return item;
            });

            rows.filter((row) => !namedRows.includes(row)).forEach((row) => {
                row.querySelector('[data-icon-upload]')?.removeAttribute('name');
                row.querySelector('[data-icon-url]')?.removeAttribute('name');
            });

            contentInput.value = JSON.stringify(items);
            contentInput.dispatchEvent(new Event('input', { bubbles: true }));
            addButton.disabled = rows.length >= 24;
        };

        repeater.addEventListener('input', (event) => {
            const row = event.target.closest('[data-icon-row]');

            if (!row) {
                return;
            }

            if (event.target.matches('[data-icon-url]')) {
                showPreview(row, event.target.value.trim() || row.dataset.imagePath || '');
            }

            if (event.target.matches('[data-icon-name], [data-icon-description], [data-icon-url]')) {
                syncIconRows();
            }
        });

        repeater.addEventListener('change', (event) => {
            const row = event.target.closest('[data-icon-row]');

            if (!row) {
                return;
            }

            if (event.target.matches('[data-icon-upload]')) {
                const file = event.target.files?.[0];

                if (!file) {
                    delete event.target.dataset.previewImage;
                    showPreview(row, row.querySelector('[data-icon-url]')?.value.trim() || row.dataset.imagePath || '');
                    syncIconRows();

                    return;
                }

                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    event.target.dataset.previewImage = reader.result;
                    const imageUrlInput = row.querySelector('[data-icon-url]');
                    if (imageUrlInput) {
                        imageUrlInput.value = '';
                    }
                    showPreview(row, reader.result);
                    syncIconRows();
                });
                reader.readAsDataURL(file);
            } else if (event.target.matches('[data-icon-url]')) {
                showPreview(row, event.target.value.trim() || row.dataset.imagePath || '');
                syncIconRows();
            }
        });

        repeater.addEventListener('click', (event) => {
            if (event.target.matches('[data-icon-remove]')) {
                event.target.closest('[data-icon-row]')?.remove();
                syncIconRows();
            }
        });

        addButton.addEventListener('click', () => {
            if (rowsContainer.querySelectorAll('[data-icon-row]').length >= 24) {
                return;
            }

            rowsContainer.append(rowTemplate.content.cloneNode(true));
            const newRow = rowsContainer.lastElementChild;
            newRow?.querySelector('[data-icon-name]')?.focus();
            syncIconRows();
        });

        syncIconRows();
    });

    form.addEventListener('submit', () => {
        form.querySelectorAll('[data-admin-content-input], [data-admin-image-url]').forEach((input) => {
            const field = input.closest('.admin-field');
            const clearField = field?.querySelector('.admin-clear-field input');
            const uploadField = field?.querySelector('input[type="file"]');
            const hasNewUpload = Boolean(uploadField?.files.length);
            const isUnchanged = input.value === input.dataset.adminOriginal;

            if (isUnchanged && !clearField?.checked && !hasNewUpload) {
                input.disabled = true;
            }
        });
    });
});
document.querySelectorAll('.back-to-top').forEach((backToTopButton) => {
    backToTopButton.addEventListener('click', (event) => {
        event.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});

const motionSelectors = [
    'main > section',
    '.home-feature-card',
    '.home-promise-card',
    '.home-device-card',
    '.home-work-step',
    '.home-results-stat',
    '.home-results-feature',
    '.home-testimonial',
    '.solution-detail',
    '.protocol-badges > *',
    '.automation-pillar',
    '.scene-cards > *',
    '.lifestyle-cards > *',
    '.services-specialty-card',
    '.services-journey__steps li',
    '.values-card',
    '.contact-detail-card',
    '.blog-article-card',
    '.catalog-solutions .solution-card',
].join(', ');
const motionTargets = [...document.querySelectorAll(motionSelectors)];
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (motionTargets.length > 0 && !document.body.classList.contains('admin-page') && !prefersReducedMotion && 'IntersectionObserver' in window) {
    document.body.classList.add('motion-enabled');

    const motionObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -32px 0px' });

    motionTargets.forEach((target) => {
        const siblings = [...target.parentElement.children].filter((sibling) => sibling.matches(motionSelectors));
        const siblingIndex = siblings.indexOf(target);

        target.classList.add('motion-reveal');
        target.style.setProperty('--motion-delay', `${Math.min(siblingIndex, 4) * 75}ms`);
        motionObserver.observe(target);
    });

    document.querySelectorAll('.home-device-card, .automation-pillar, .services-specialty-card, .values-card').forEach((card) => {
        card.classList.add('motion-hover');
    });
}
