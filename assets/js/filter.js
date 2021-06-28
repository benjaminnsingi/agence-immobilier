import {Flipper, spring} from 'flip-toolkit'

/**
 * @property {HTMLElement} pagination
 * @property {HTMLElement} content
 * @property {HTMLFormElement} form
 * @property {number} page
 * @property {boolean} moreNav
 */
export default class Filter {

    /**
     * @param {HTMLElement|null} element
     */
    constructor (element) {
        if (element === null) {
            return
        }
        this.pagination = element.querySelector('.js-filter-pagination')
        this.content = element.querySelector('.js-filter-content')
        this.form = element.querySelector('.js-filter-form')
        this.page = parseInt(new URLSearchParams(window.location.search).get('page') || 1)
        this.moreNav = this.page === 1
        this.bindEvents()
    }

    /**
     * Adds behaviors to the different elements
     */
    bindEvents () {
        const aClickListener = e => {
            if (e.target.tagName === 'A') {
                e.preventDefault()
                this.loadUrl(e.target.getAttribute('href'))
            }
        }
        if (this.moreNav) {
            this.pagination.innerHTML = '<button class="btn btn-primary">Voir plus</button>'
            this.pagination.querySelector('button').addEventListener('click', this.loadMore.bind(this))
        } else {
            this.pagination.addEventListener('click', aClickListener)
        }
        this.form.querySelectorAll('input').forEach(input => {
            input.addEventListener('change', this.loadForm.bind(this))
        })
    }

    async loadMore () {
        const button = this.pagination.querySelector('button')
        button.setAttribute('disabled', 'disabled')
        this.page++
        const url = new URL(window.location.href)
        const params = new URLSearchParams(url.search)
        params.set('page', this.page)
        await this.loadUrl(url.pathname + '?' + params.toString(), true)
        button.removeAttribute('disabled')
    }

    async loadForm () {
        this.page = 1
        const data = new FormData(this.form)
        const url = new URL(this.form.getAttribute('action') || window.location.href)
        const params = new URLSearchParams()
        data.forEach((value, key) => {
            params.append(key, value)
        })
        return this.loadUrl(url.pathname + '?' + params.toString())
    }

    async loadUrl (url, append = false) {
        const params = new URLSearchParams(url.split('?')[1] || '')
        params.set('ajax', 1)
        const response = await fetch(url.split('?')[0] + '?' + params.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        if (response.status >= 200 && response.status < 300) {
            const data = await response.json()
            this.flipContent(data.content, append)
            if (!this.moreNav) {
                this.pagination.innerHTML = data.pagination
            } else if (this.page === data.pages) {
                this.pagination.style.display = 'none';
            } else {
                this.pagination.style.display = null;
            }
            this.updatePrices(data)
            params.delete('ajax')
            history.replaceState({}, '', url.split('?')[0] + '?' + params.toString())
        } else {
            console.error(response)
        }
    }

    /**
     * Replace the elements of the grid with a flip animation effect
     * @param {string} content
     */
    flipContent (content, append) {
        const springConfig = 'gentle'
        const exitSpring = function (element, index, onComplete) {
            spring({
                config: 'stiff',
                values: {
                    translateY: [0, -20],
                    opacity: [1, 0]
                },
                onUpdate: ({ translateY, opacity }) => {
                    element.style.opacity = opacity;
                    element.style.transform = `translateY(${translateY}px)`;
                },
                onComplete
            })
        }
        const appearSpring = function (element, index) {
            spring({
                config: 'stiff',
                values: {
                    translateY: [20, 0],
                    opacity: [0, 1]
                },
                onUpdate: ({ translateY, opacity }) => {
                    element.style.opacity = opacity;
                    element.style.transform = `translateY(${translateY}px)`;
                },
                delay: index * 20
            })
        }
        const flipper = new Flipper({
            element: this.content
        })
        this.content.children.forEach(element => {
            // add flipped children to the parent
            flipper.addFlipped({
                element,
                spring: springConfig,
                // assign a unique id to the element
                flipId: element.id,
                shouldFlip: false,
                onExit: exitSpring
            })
        })
        flipper.recordBeforeUpdate()
        if (append) {
            this.content.innerHTML += content
        } else {
            this.content.innerHTML = content
        }
        this.content.children.forEach(element => {
            // add flipped children to the parent
            flipper.addFlipped({
                element,
                spring: springConfig,
                // assign a unique id to the element
                flipId: element.id,
                onAppear: appearSpring
            })
        })
        flipper.update()
    }

    updatePrices ({min, max}) {
        const slider = document.getElementById('price-slider')
        if (slider === null) {
            return
        }
        slider.noUiSlider.updateOptions({
            range: {
                min: [min],
                max: [max]
            }
        })
    }

}
