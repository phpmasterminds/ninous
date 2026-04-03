{literal}
<style>
/* ===== Wizard Layout ===== */
.dating-wizard-wrapper {
    background: #fff;
    border: 1px solid #ddd;
    padding: 20px;
}

.dating-wizard-steps {
    display: flex;
    margin-bottom: 15px;
    overflow-x: auto;
    gap: 0;
    padding: 20px 0;
    flex-wrap: nowrap;
}

.wizard-step {
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    opacity: 0.5;
    color: #fff;
    position: relative;
    clip-path: polygon(0 0, calc(100% - 15px) 0, 100% 50%, calc(100% - 15px) 100%, 0 100%, 15px 50%);
    background: var(--step-color);
    margin-left: -8px;
}

.wizard-step:first-child {
    margin-left: 0;
    clip-path: polygon(0 0, calc(100% - 15px) 0, 100% 50%, calc(100% - 15px) 100%, 0 100%);
}

.wizard-step.active {
    opacity: 1;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    transform: scale(1.05);
}

.wizard-step:hover {
    opacity: 0.8;
}

.step-number {
    font-weight: 700;
    font-size: 16px;
    margin-right: 4px;
}

.wizard-body {
    display: flex;
    gap: 20px;
    min-height: 400px;
}

.wizard-description {
    width: 30%;
    padding: 20px;
    background: #f5f5f5;
    border-radius: 4px;
    color: #666;
    font-size: 14px;
    line-height: 1.6;
}

.wizard-content {
    width: 70%;
    overflow-y: auto;
    max-height: 600px;
}

.wizard-page {
    display: none;
}

.wizard-page.active {
    display: block;
}

.section-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 30px;
    color: #333;
    padding-bottom: 15px;
    border-bottom: 3px solid #e0e0e0;
}

/* ===== Sub-tabs Styling ===== */
.sub-tabs {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0px 0 30px 0;
    border-bottom: 2px solid #efefef;
    gap: 30px;
}

.sub-tab {
    padding: 12px 0;
    cursor: pointer;
    color: var(--step-sub-color);
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 15px;
    position: relative;
}

.sub-tab:hover {
    color: var(--step-sub-color);
}

.sub-tab.active {
    *color: #ffc000;
    border-bottom-color: var(--step-sub-color);
}

/* ===== Sub-content ===== */
.sub-content {
    display: none;
}

.sub-content.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* ===== Form Groups ===== */
.form-group {
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
    font-size: 14px;
}

.form-group input[type="text"],
.form-group textarea,
.form-group select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    font-family: inherit;
    transition: border-color 0.3s ease;
}

.form-group input[type="text"]:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: #2d89ef;
    box-shadow: 0 0 0 2px rgba(45, 137, 239, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.form-group input[type="checkbox"],
.form-group input[type="radio"] {
    cursor: pointer;
    width: 18px;
    height: 18px;
    margin-right: 8px;
}

.checkbox-group,
.radio-group,
.multiple-choice-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.checkbox-group label,
.radio-group label,
.multiple-choice-group label {
    display: flex;
    align-items: center;
    cursor: pointer;
    margin: 0;
    font-weight: normal;
}

/* ===== Wizard Actions ===== */
.wizard-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #ddd;
}

.wizard-actions button {
    padding: 10px 25px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
}

#wizardBack {
    background: #f0f0f0;
    color: #333;
}

#wizardBack:hover {
    background: #e0e0e0;
}

#wizardBack:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

#wizardNext {
    background: #2d89ef;
    color: #fff;
}

#wizardNext:hover {
    background: #1f6cc9;
}

#wizardNext:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* ===== Loading State ===== */
.wizard-loading {
    display: none;
    text-align: center;
    padding: 20px;
    color: #666;
}

.wizard-loading.show {
    display: block;
}

.spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #2d89ef;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-right: 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* ===== Error Messages ===== */
.error-message {
    color: #d32f2f;
    font-size: 13px;
    margin-top: 5px;
}

.wizard-error {
    padding: 15px;
    background: #ffebee;
    border: 1px solid #f5a5a5;
    color: #d32f2f;
    border-radius: 4px;
    margin-bottom: 20px;
    display: none;
}

.wizard-error.show {
    display: block;
}
.wizard-step.wizard-completed {
    background: var(--step-color);
    color: #fff;
	opacity:1;
}

.wizard-step.is-locked {
    pointer-events: none;
    opacity: 0.5;
    cursor: not-allowed;
}

.wizard-step.is-locked::after {
    content: "🔒";
    margin-left: 6px;
    font-size: 14px;
}


</style>
{/literal}

<div class="dating-wizard-wrapper">

    <!-- ===== Wizard Steps Header (Chevron Design) ===== -->
    <div class="dating-wizard-steps" id="wizardSteps">
        {foreach from=$aSections item=section key=iKey}
            <div class="wizard-step" 
                 data-step="{$iKey}"
                 style="--step-color: {$section.background_color}; --step-color-light: {$section.background_color}80;"
                 data-section-id="{$section.section_id}">
                <span class="step-number">{$iKey+1}</span> {$section.section_name}
            </div>
        {/foreach}
    </div>

    <!-- ===== Error Message Box ===== -->
    <div class="wizard-error" id="wizardError"></div>

    <!-- ===== Wizard Body ===== -->
    <form id="datingWizardForm">

        <div class="wizard-body">

            <!-- Left Side: Description -->
            <div class="wizard-description">
                <div id="wizardDescription">
                    {$aSections[0].description}
                </div>
            </div>

            <!-- Right Side: Form Content -->
            <div class="wizard-content">
                {foreach from=$aSections item=section key=stepKey}
                    <div class="wizard-page" data-page="{$stepKey}">
					
					{if $stepKey == 5}
						<div id="datingcont"></div>

					 
    <script>
        {literal}
        setTimeout(function(){
            $('#page_dating_index #main').addClass("empty-right");
            getDatingUser("{/literal}{$searchtext}{literal}");
        },4000);
		function getDatingUser(searchText)
		{
			$.ajaxCall('dating.getMatchingUser','searchtext=' + searchText);
		}
        {/literal}
    </script>
    
	
						{else}
                        <!-- Step Title 
                        <h2 class="section-title">{$section.section_name}</h2>-->

                        <!-- Sub-section Tabs (if exist) -->
                        {if $section.sub_sections|count > 1}
                            <ul class="sub-tabs" data-step="{$stepKey}">
                                {foreach from=$section.sub_sections item=sub key=subKey}
                                    <li class="sub-tab {if $subKey==0}active{/if}"
                                        data-section-id="{$sub.section_id}"
                                        data-sub="{$subKey}" style="--step-sub-color: {$sub.color};">
                                        {$sub.section_name}
                                    </li>
                                {/foreach}
                            </ul>
                        {/if}
                        <!-- Sub-section Content -->
                        {foreach from=$section.sub_sections item=sub key=subKey}
                            <div class="sub-content {if $subKey==0}active{/if}"
                                 data-step="{$stepKey}"
                                 data-section-id="{$sub.section_id}"
                                 data-sub="{$subKey}">

                                {if empty($sub.fields)}
                                    <p style="color: #999; font-style: italic;">No fields in this section</p>
                                {else}
                                    {foreach from=$sub.fields item=field}
                                        <div class="form-group">
                                            <label for="field_{$field.field_id}">
                                                {$field.title}{if $field.is_required == 1}{required}{/if}
                                            </label>

                                            {if $field.type == 'text'}
                                                <input type="text"
                                                       id="field_{$field.field_id}"
                                                       name="answers[{$field.field_id}]"
                                                       class="form-control field-input"
                                                       data-field-id="{$field.field_id}"
                                                       data-section-id="{$sub.section_id}"
													   {if $field.is_required == 1}required aria-required="true"{/if}
													    value="{php}if (!empty($this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']])) { echo $this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']];} {/php}"

													   />
													   

                                            {elseif $field.type == 'textarea'}
                                                <textarea id="field_{$field.field_id}"
                                                          name="answers[{$field.field_id}]"
                                                          class="form-control field-input"
                                                          data-field-id="{$field.field_id}"
                                                          data-section-id="{$sub.section_id}"
														  {if $field.is_required == 1}required aria-required="true"{/if}
														  >{php}if (!empty($this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']])) { echo $this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']];} {/php}</textarea>

                                            {elseif $field.type == 'checkbox'}
                                                <div class="checkbox-group">
                                                    <label>
                                                        <input type="checkbox"
                                                               name="answers[{$field.field_id}]"
                                                               value="1"
                                                               class="field-input"
                                                               data-field-id="{$field.field_id}"
                                                               data-section-id="{$sub.section_id}"
															   {if $field.is_required == 1}data-required-group="1"{/if}
															   {php}if (!empty($this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']])) { echo 'checked';} {/php}
															   />
                                                        {$field.title}
                                                    </label>
                                                </div>

                                            {elseif $field.type == 'radio'}
                                                <div class="radio-group">
                                                    {if !empty($field.options) && is_array($field.options)}
                                                        {foreach from=$field.options item=option}
                                                            <label>
                                                                <input type="radio"
                                                                       name="answers[{$field.field_id}]"
                                                                       value="{$option}"
                                                                       class="field-input"
                                                                       data-field-id="{$field.field_id}"
                                                                       data-section-id="{$sub.section_id}"
																	   {if $field.is_required == 1}required{/if}
																	 {php}
       if (
           isset($this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']]) &&
           $this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']] == $this->_aVars['option']
       ) {
           echo 'checked';
       }
       {/php}
																	   
																	   />
                                                                {$option}
                                                            </label>
                                                        {/foreach}
                                                    {/if}
                                                </div>

                                            {elseif $field.type == 'multiple'}
                                                <div class="multiple-choice-group">
                                                    {if !empty($field.options) && is_array($field.options)}
                                                        {foreach from=$field.options item=option}
                                                            <label>
                                                                <input type="checkbox"
                                                                       name="answers[{$field.field_id}][]"
                                                                       value="{$option}"
                                                                       class="field-input"
                                                                       data-field-id="{$field.field_id}"
                                                                       data-section-id="{$sub.section_id}"
																	   {if $field.is_required == 1}data-required-group="1"{/if}
																	    {php}
$value = $this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']] ?? null;

if (is_string($value)) {
    $value = json_decode($value, true);
}

if (
    is_array($value) &&
    in_array($this->_aVars['option'], $value)
) {
    echo 'checked';
}
{/php}

																	   />
                                                                {$option}
                                                            </label>
                                                        {/foreach}
                                                    {/if}
                                                </div>

                                            {elseif $field.type == 'select'}
                                                <select id="field_{$field.field_id}"
                                                        name="answers[{$field.field_id}]"
                                                        class="form-control field-input"
                                                        data-field-id="{$field.field_id}"
                                                        data-section-id="{$sub.section_id}"
														{if $field.is_required == 1}required aria-required="true"{/if}
														>
                                                    <option value="">-- Select --</option>
                                                    {foreach from=$field.options item=option}
                                                        <option value="{$option.value|escape}" {php}
    if (
        isset($this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']]) &&
        $this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']] == $this->_aVars['option']['value']
    ) {
        echo 'selected';
    }
    {/php}>
                                                            {$option.label|escape}
                                                        </option>
                                                    {/foreach}
                                                </select>
                                            {/if}
                                        </div>
                                    {/foreach}
                                {/if}

                            </div>
                        {/foreach}
							{/if}
                    </div>
                {/foreach}

            </div>
        </div>

    </form>

    <!-- ===== Wizard Actions ===== -->
    <div class="wizard-actions">
        <button type="button" id="wizardBack" style="display:none">← Back</button>
        <button type="button" id="wizardNext">Next →</button>
    </div>

</div>

{literal}
<script>
(function() {
    'use strict';

    // ===== Configuration =====
    const config = {
        currentStep: 0,
        totalSteps: document.querySelectorAll('.wizard-page').length,
        sections: {/literal}{$aSections|json_encode}{literal}
    };

    // ===== DOM Elements =====
    const elements = {
        wizardSteps: document.getElementById('wizardSteps'),
        wizardPages: document.querySelectorAll('.wizard-page'),
        wizardForm: document.getElementById('datingWizardForm'),
        wizardDescription: document.getElementById('wizardDescription'),
        wizardBack: document.getElementById('wizardBack'),
        wizardNext: document.getElementById('wizardNext'),
        wizardError: document.getElementById('wizardError'),
        subTabs: document.querySelectorAll('.sub-tabs'),
        subContents: document.querySelectorAll('.sub-content')
    };

    /**
     * Show specific wizard step
     */
    function showStep(step) {
        // Validate step
        if (step < 0 || step >= config.totalSteps) return;

        config.currentStep = step;

        // Hide all pages
        elements.wizardPages.forEach(page => {
            page.classList.remove('active');
        });

        // Show current page
        const currentPage = document.querySelector(`.wizard-page[data-page="${step}"]`);
        if (currentPage) {
            currentPage.classList.add('active');
        }

        // Update step indicators
        document.querySelectorAll('.wizard-step').forEach((stepEl, index) => {
            stepEl.classList.toggle('active', index === step);
        });

        // Update description
        if (config.sections[step]) {
			if(config.currentStep != 5){
				elements.wizardDescription.textContent = config.sections[step].description || '';
				elements.wizardDescription.closest('.wizard-description').style.display = 'block';
				$('.wizard-content').css('width', '70%');
			}
			else{
				elements.wizardDescription.closest('.wizard-description').style.display = 'none';
				$('.wizard-content').css('width', '100%');

			}
        }

        // Show first sub-section tab
        const currentSubTabs = document.querySelector(`.sub-tabs[data-step="${step}"]`);
        if (currentSubTabs) {
            const firstTab = currentSubTabs.querySelector('.sub-tab');
            if (firstTab) {
                activateSubTab(firstTab);
            }
        }

        // Update button states
        elements.wizardBack.style.display = step === 0 ? 'none' : 'inline-block';
        elements.wizardBack.disabled = step === 0;
        
        elements.wizardNext.textContent = step === config.totalSteps - 1 ? 'Finish' : 'Next →';
        elements.wizardNext.disabled = false;

        // Clear error message
        hideError();
    }

    /**
     * Activate sub-tab and show corresponding content
     */
    function activateSubTab(tabElement) {
        const step = tabElement.closest('.sub-tabs').dataset.step;
        const sectionId = tabElement.dataset.sectionId;

        // Deactivate all tabs in this step
        document.querySelectorAll(`.sub-tabs[data-step="${step}"] .sub-tab`).forEach(tab => {
            tab.classList.remove('active');
        });

        // Deactivate all content in this step
        document.querySelectorAll(`.sub-content[data-step="${step}"]`).forEach(content => {
            content.classList.remove('active');
        });

        // Activate clicked tab
        tabElement.classList.add('active');

        // Activate corresponding content
        const contentElement = document.querySelector(
            `.sub-content[data-step="${step}"][data-section-id="${sectionId}"]`
        );
        if (contentElement) {
            contentElement.classList.add('active');
        }
    }

    /**
     * Collect form data for current step - ENHANCED for radio & multiple choice
     */
    function collectStepData(step) {
		const stepData = {
			step: step,
			section_id: config.sections[step].section_id,
			val: {} // 👈 important
		};

		const currentPage = document.querySelector(`.wizard-page[data-page="${step}"]`);
		if (!currentPage) return stepData;

		const processedFields = new Set();

		currentPage.querySelectorAll('.field-input').forEach(input => {
			const fieldId = input.dataset.fieldId;
			let value = '';

			if (input.type === 'checkbox' && input.name.includes('[]')) {
				if (!processedFields.has(fieldId)) {
					const checkedValues = [];
					currentPage
						.querySelectorAll(`.field-input[data-field-id="${fieldId}"]:checked`)
						.forEach(cb => checkedValues.push(cb.value));

					if (checkedValues.length > 0) {
						stepData.val[`field_${fieldId}`] = checkedValues;
					}
					processedFields.add(fieldId);
				}
			} else if (input.type === 'checkbox') {
				if (input.checked) {
					stepData.val[`field_${fieldId}`] = input.value;
				}
			} else if (input.type === 'radio') {
				if (input.checked) {
					stepData.val[`field_${fieldId}`] = input.value;
				}
			} else {
				value = input.value;
				if (value !== '') {
					stepData.val[`field_${fieldId}`] = value;
				}
			}
		});

		return stepData;
	}


    /**
     * Validate step data (optional)
     */
    function validateStep(step) {
        // Add your validation logic here
        // Return true if valid, false otherwise
        return true;
    }

    /**
     * Save current step via AJAX
     */
    function saveStep(step) {
        const stepData = collectStepData(step);

        // Show loading state
        showLoading();

        return new Promise((resolve, reject) => {
            $.ajax({
                url: $.ajaxBox('dating.saveWizardStep'),
                type: 'POST',
                dataType: 'json',
                data: stepData,
                success: function(response) {
                    hideLoading();
                    
                    if (response.error) {
                        showError(response.message || 'An error occurred');
                        reject(new Error(response.message));
                    } else {
                        resolve(response);
                    }
                },
                error: function(xhr, status, error) {
                    hideLoading();
                    const errorMsg = xhr.responseJSON?.message || 'Failed to save. Please try again.';
                    showError(errorMsg);
                    reject(new Error(errorMsg));
                }
            });
        });
    }

    /**
     * Show error message
     */
    function showError(message) {
        elements.wizardError.textContent = message;
        elements.wizardError.classList.add('show');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /**
     * Hide error message
     */
    function hideError() {
        elements.wizardError.classList.remove('show');
    }

    /**
     * Show loading indicator
     */
    function showLoading() {
        elements.wizardNext.disabled = true;
        elements.wizardBack.disabled = true;
        elements.wizardNext.innerHTML = '<span class="spinner"></span>Saving...';
    }

    /**
     * Hide loading indicator
     */
    function hideLoading() {
        elements.wizardNext.disabled = false;
        elements.wizardBack.disabled = config.currentStep === 0;
        updateNextButtonText();
    }

    /**
     * Update Next button text
     */
    function updateNextButtonText() {
        const isLastStep = config.currentStep === config.totalSteps - 1;
        elements.wizardNext.textContent = isLastStep ? 'Finish' : 'Next →';
    }
	
	document.addEventListener('click', function (e) {
		const stepEl = e.target.closest('.wizard-step');

		if (!stepEl) return;

		const targetStep = parseInt(stepEl.dataset.step, 10);

		// You MUST already have this variable
		if (typeof config.currentStep === 'undefined') return;

		// Same step → allow
		if (targetStep === config.currentStep) return;

		// Validate current step
		if (!validateCurrentStep(config.currentStep)) {
			e.preventDefault();
			e.stopPropagation();
			showError('Please complete all required fields before continuing.');
			return;
		}

		// Allow navigation
		showStep(targetStep);
	});

    /**
     * Handle Next button click
     */
    elements.wizardNext.addEventListener('click', function() {
        if (!validateStep(config.currentStep)) {
            showError('Please fill all required fields');
            return;
        }
		if (!validateCurrentStep(config.currentStep)) {
			showError('Please complete all required fields.');
			return;
		}


        saveStep(config.currentStep)
            .then(function(response) {
                if (config.currentStep < config.totalSteps - 1) {
                    // Move to next step
                    config.currentStep++;
                    showStep(config.currentStep);
                } else {
                    // Wizard completed
                    alert('Wizard completed successfully!');
                    // Optionally redirect or reset form
                    // window.location.href = '/dating/profile';
                }
            })
            .catch(function(error) {
                console.error('Step save error:', error);
            });
    });

    /**
     * Handle Back button click
     */
    elements.wizardBack.addEventListener('click', function() {
        if (config.currentStep > 0) {
            config.currentStep--;
            showStep(config.currentStep);
        }
    });

    /**
     * Handle step indicator click
     */
    /*document.addEventListener('click', function(event) {
        const stepElement = event.target.closest('.wizard-step');
        if (stepElement) {
            const step = parseInt(stepElement.dataset.step);
            if (!isNaN(step)) {
                showStep(step);
            }
        }
    });*/

    /**
     * Handle sub-tab click
     */
    document.addEventListener('click', function(event) {
        const tabElement = event.target.closest('.sub-tab');
        if (tabElement) {
            activateSubTab(tabElement);
        }
    });

    /**
     * Initialize wizard on page load
     */
    document.addEventListener('DOMContentLoaded', function() {
        showStep(0);
    });

    // Prevent form submission
    elements.wizardForm.addEventListener('submit', function(event) {
        event.preventDefault();
        return false;
    });
})();
function validateCurrentStep(step) {
    let isValid = true;

    const page = document.querySelector(`.wizard-page[data-page="${step}"]`);
    if (!page) return true;

    // 1. Normal required inputs
    page.querySelectorAll('[required]').forEach(el => {
        if (
            (el.type === 'radio' && !page.querySelector(`input[name="${el.name}"]:checked`)) ||
            (el.type !== 'radio' && !el.value.trim())
        ) {
            el.focus();
            isValid = false;
            return false;
        }
    });

    // 2. Required multiple checkbox groups
    const groups = {};
    page.querySelectorAll('[data-required-group="1"]').forEach(cb => {
        groups[cb.name] = groups[cb.name] || [];
        groups[cb.name].push(cb);
    });

    Object.values(groups).forEach(group => {
        if (!group.some(cb => cb.checked)) {
            group[0].focus();
            isValid = false;
        }
    });

    return isValid;
}

function isSectionCompleted(sectionId) {
    const fields = document.querySelectorAll(
        `.field-input[data-section-id="${sectionId}"]`
    );

    let valid = true;

    // Group fields by name (important for radios & checkbox groups)
    const grouped = {};

    fields.forEach(field => {
        const name = field.name || field.dataset.fieldId;
        if (!grouped[name]) grouped[name] = [];
        grouped[name].push(field);
    });

    Object.values(grouped).forEach(group => {
        const field = group[0];

        // Required checkbox group
        if (field.dataset.requiredGroup === "1") {
            const checked = group.some(f => f.checked);
            if (!checked) valid = false;
        }
        // Radio group
        else if (field.type === "radio" && field.required) {
            const checked = group.some(f => f.checked);
            if (!checked) valid = false;
        }
        // Normal required field
        else if (field.required) {
            if (!field.value || !field.value.trim()) {
                valid = false;
            }
        }
    });

    return valid;
}

function updateWizardSteps() {
    document.querySelectorAll('.wizard-step').forEach(step => {
        const stepIndex = step.dataset.step;
if(stepIndex == 5) return;
        // all sections under this step
        const sections = document.querySelectorAll(
            `.sub-content[data-step="${stepIndex}"]`
        );

        let stepCompleted = true;

        sections.forEach(section => {
            const sectionId = section.dataset.sectionId;
            if (!isSectionCompleted(sectionId)) {
                stepCompleted = false;
            }
        });

        step.classList.toggle('wizard-completed', stepCompleted);
    });
}

/* ✅ Run on page load */
document.addEventListener('DOMContentLoaded', updateWizardSteps);
/* ✅ Run on change */
document.addEventListener('change', function (e) {
    if (e.target.classList.contains('field-input')) {
        updateWizardSteps();
    }
});
</script>
{/literal}