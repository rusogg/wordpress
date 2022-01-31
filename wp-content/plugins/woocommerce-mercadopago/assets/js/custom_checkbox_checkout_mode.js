function getCheckboxTableString() {
    const testLabel = document.getElementById('checkout-mode-checkbox-test');

    if (!testLabel || !testLabel.parentElement) return null;

    let testLabelParent = testLabel.parentElement;

    while (testLabelParent.nodeName !== 'TABLE') {
        testLabelParent = testLabelParent.parentElement;
    }
    
    return testLabelParent.id;
}

function hideColumnEmptyFromCheckbox(checkboxTableString) {
    const columnEmptyFromTestCheckbox = document.querySelector(`#${checkboxTableString} > tbody > tr > th#mp_field_text.titledesc`);
    const columnEmptyFromProductionCheckbox = document.querySelector(`#${checkboxTableString} > tbody > tr:nth-child(2) > th`);

    columnEmptyFromTestCheckbox.style.display = "none";
    columnEmptyFromProductionCheckbox.style.display = "none";
}

function customizeCheckboxContainer(checkboxTableString) {
    const testCheckboxContainer = document.querySelector(`#${checkboxTableString} > tbody > tr:first-child > td`);
    const productionCheckboxContainer = document.querySelector(`#${checkboxTableString} > tbody > tr:nth-child(2) > td`);

    testCheckboxContainer.style.padding = '0px';
    testCheckboxContainer.style.marginBottom = '14px';
    testCheckboxContainer.style.paddingTop = '14px';
    productionCheckboxContainer.style.padding = '0px';
    productionCheckboxContainer.style.marginBottom = '14px';
    productionCheckboxContainer.style.paddingTop = '14px';
}

function customizeCheckboxLabel(checkboxTableString) {
    const testCheckboxLabel = document.querySelector(`#${checkboxTableString} > tbody > tr > td.forminp > fieldset > label`);
    const productionCheckboxLabel = document.querySelector(`#${checkboxTableString} > tbody > tr:nth-child(2) > td.forminp > fieldset > label`);

    testCheckboxLabel.style.color = 'black';
    testCheckboxLabel.style.border = 'none';
    testCheckboxLabel.style.width = '100%';
    testCheckboxLabel.style.setProperty("margin", "0", "important");
    testCheckboxLabel.style.setProperty("padding", "0", "important");

    productionCheckboxLabel.style.color = 'black';
    productionCheckboxLabel.style.border = 'none';
    productionCheckboxLabel.style.width = '100%';
    productionCheckboxLabel.style.setProperty("margin", "0", "important");
    productionCheckboxLabel.style.setProperty("padding", "0", "important");
}

function customizeCheckboxDescription(checkboxTableString) {
    const testCheckboxDescription = document.querySelector(`#${checkboxTableString} > tbody > tr > td.forminp > fieldset > p.description`);
    const productionCheckboxDescription = document.querySelector(`#${checkboxTableString} > tbody > tr:nth-child(2) > td.forminp > fieldset > p.description`);

    testCheckboxDescription.style.marginLeft = "24px";
    testCheckboxDescription.style.whiteSpace = "nowrap";
    productionCheckboxDescription.style.marginLeft = "24px";
    productionCheckboxDescription.style.whiteSpace = "nowrap";
}

function checkCorrectInput(testCheckbox, productionCheckbox) {
    const testLabel = document.querySelector("#checkout-mode-checkbox-test");
    const testIsChecked = testLabel.classList.contains('checked');
    const productionLabel = document.querySelector("#checkout-mode-checkbox-production");
    const productionIsChecked = productionLabel.classList.contains('checked');

    testCheckbox.checked = testIsChecked;
    productionCheckbox.checked = productionIsChecked;
}

function addInputRadioLogic(testCheckbox, productionCheckbox) {
    testCheckbox.addEventListener('change', () => {
        if (!testCheckbox.checked || productionCheckbox.checked) {
            testCheckbox.checked = true;
            testCheckbox.classList.add("checked");
            productionCheckbox.checked = false;
            productionCheckbox.classList.remove("checked");
        }
    });

    productionCheckbox.addEventListener('change', () => {
        if (!productionCheckbox.checked || testCheckbox.checked) {
            productionCheckbox.checked = true;
            productionCheckbox.classList.add("checked");
            testCheckbox.checked = false;
            testCheckbox.classList.remove("checked");
        }
    });
}

window.addEventListener("load", () => {
    const checkboxTableString = getCheckboxTableString();

    if (checkboxTableString) {
        const testCheckbox = document.querySelector('[id*="test_mode"]');
        const productionCheckbox = document.querySelector('[id*="production_mode"]');
    
        hideColumnEmptyFromCheckbox(checkboxTableString);
        customizeCheckboxContainer(checkboxTableString);
        customizeCheckboxLabel(checkboxTableString);
        customizeCheckboxDescription(checkboxTableString);
        checkCorrectInput(testCheckbox, productionCheckbox);
        addInputRadioLogic(testCheckbox, productionCheckbox)
    }
});
