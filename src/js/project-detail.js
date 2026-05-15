document.addEventListener('DOMContentLoaded', (event) => {
    const contentElement = document.getElementById('customScrollbar')

    const simpleBarInstance = new SimpleBar(contentElement, {
        autoHide: false,
        forceVisible: "y"
    })

    // active scroll
    contentElement.classList.add('simplebar-active')

    // Resize
    const resizeObserver = new ResizeObserver(() => {
        simpleBarInstance.recalculate()
    });

    resizeObserver.observe(contentElement);
});