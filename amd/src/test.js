//import jQuery from 'jquery';

export const init = () => {
    // Allow highlighted notes to be saved
    let container = document.querySelector('.annotation-container');
    container.addEventListener('mouseup', () => {
        let selection = window.getSelection();
        // Get properties for annotation object to store
        // as long as the selection includes at least
        // one character.
        if(selection.type == 'Range') {
            // If the anchor node of the selection is not
            // an "element" node type (1), work through its
            // parent nodes until the appropriate node type is found.
            let anchor = selection.anchorNode;
            while(anchor.nodeType != 1) {
                anchor = anchor.parentNode;
            }
            // Now that we have the element node, grab its index
            let anchorElementIndex = anchor.getAttribute('id');
            // We also need to store the index of the #text node
            // in the context of the anchor parent node's childNodes array.
            let anchorNodeIndex = Array.prototype.indexOf.call(anchor.childNodes, selection.anchorNode);

            // Do the same for the focus node.
            let focus = selection.focusNode;
            while(focus.nodeType != 1) {
                focus = focus.parentNode;
            }
            // Now that we have the element node, grab its index
            let focusElementIndex = focus.getAttribute('id');
            // Again, get the index of the child #text node
            let focusNodeIndex = Array.prototype.indexOf.call(focus.childNodes, selection.focusNode);

            // Assemble a storable annotation object
            let annotation = {
                anchorElementIndex: anchorElementIndex,
                anchorOffset: selection.anchorOffset,
                anchorNodeIndex: anchorNodeIndex,
                focusElementIndex: focusElementIndex,
                focusOffset: selection.focusOffset,
                focusNodeIndex: focusNodeIndex,
                text: selection.toString()
            };
            window.console.log(annotation);
        }
    });

    // Allow saved notes to be retrieved
    let loadButton = document.querySelector('.load-button');
    loadButton.addEventListener('click', () => {
        // Dummy annotation object for testing
        // let annotation = {
        //     anchorIndex: '13',
        //     anchorOffset: 308,
        //     focusIndex: '13',
        //     focusOffset: 324,
        //     text: 'im et ante moles'
        // };

        // let anchor = document.querySelector(`[data-index="${annotation.anchorIndex}"]`);
        // let focus = document.querySelector(`[data-index="${annotation.focusIndex}"]`);

        // We have to find the index of the appropriate child node
        // of the anchor and focus nodes. There can be many child nodes
        // for one element node, but each has a "length" property.
        // So we need to compare the offset property to each element's
        // length property in the anchor.childNodes array to find the correct
        // child node.
        // let anchorText = anchor.childNodes[0];
    });
};