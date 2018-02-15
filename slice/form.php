<?php $title = 'form'; ?>
<?php include 'tpl/includes/head.inc'; ?>
<body class="page">
<div class="outer-wrapper">
<?php include 'tpl/layout/header.inc'; ?>
<div class="inner-wrapper">
  <section class="section section-top">
    <div class="bg" style="background-image: url('theme/images/tmp/compounding-section-top-img.jpg');">
    </div>
    <div class="container">
      <div class="title">
        <h1>REQUEST A QUOTE</h1>
      </div>
    </div>
  </section>

  <section class="section section-quote">
  <div class="container">
    <div class="form form-quote">
      <h2>REQUEST A QUOTE</h2>
      <div class="messages error">
        <h2 class="element-invisible">Error message</h2>
        <ul>
          <li>First Name field is required.</li>
          <li>Last Name field is required.</li>
          <li>Email field is required.</li>
        </ul>
      </div>
      <div class="required"><span class="form-required">*</span> Required Field</div>
      <div class="row">
        <div class="form-item form-type-text col-sm-5">
          <span class="form-required">*</span>
          <input type="text" class="form-text error" placeholder="First Name">
        </div>
        <div class="form-item form-type-text col-sm-5">
          <span class="form-required">*</span>
          <input type="text" class="form-text" placeholder="Last Name">
        </div>
        <div class="form-item form-type-select col-sm-2">
          <select class="form-select">
            <option>Suffix</option>
            <option>Suffix</option>
            <option>Suffix</option>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="form-item form-type-text col-sm-6">
          <input type="text" class="form-text" placeholder="Company Name">
        </div>
        <div class="form-item form-type-text col-sm-6">
          <input type="text" class="form-text" placeholder="Position">
        </div>
      </div>
      <div class="row">
        <div class="form-item form-type-text col-sm-12">
          <input type="text" class="form-text" placeholder="  Address">
        </div>
      </div>
      <div class="row">
        <div class="form-item form-type-text col-sm-6">
          <input type="text" class="form-text" placeholder="City">
        </div>
        <div class="form-item form-type-select col-sm-2">
          <select class="form-select">
            <option>State</option>
            <option>State</option>
            <option>State</option>
          </select>
        </div>
        <div class="form-item form-type-text col-sm-4">
          <input type="text" class="form-text" placeholder="Zip Code">
        </div>
      </div>
      <div class="row">
        <div class="form-item form-type-text col-sm-4">
          <input type="text" class="form-text" placeholder="Phone">
        </div>
        <div class="form-item form-type-text col-sm-4">
          <input type="text" class="form-text" placeholder="Fax">
        </div>
        <div class="form-item form-type-text col-sm-4">
          <span class="form-required">*</span>
          <input type="text" class="form-text" placeholder="Email">
        </div>
      </div>
      <div class="row">
        <div class="form-item form-type-text col-sm-12">
          <textarea class="form-textarea" placeholder="Description of Project/Services Requested"></textarea>
        </div>
      </div>
      <div class="text">How did you hear about ARL?</div>
      <div class="form-item webform-component webform-component-radios webform-component--hear">
        <label class="element-invisible" for="edit-submitted-hear">Hear </label>
        <div id="edit-submitted-hear" class="form-radios"><div class="form-item form-type-radio form-item-submitted-hear">
            <input type="radio" id="edit-submitted-hear-1" name="submitted[hear]" value="web_search" class="form-radio">  <label class="option" for="edit-submitted-hear-1">Web Search </label>

          </div>
          <div class="form-item form-type-radio form-item-submitted-hear">
            <input type="radio" id="edit-submitted-hear-2" name="submitted[hear]" value="association" class="form-radio">  <label class="option" for="edit-submitted-hear-2">Association </label>

          </div>
          <div class="form-item form-type-radio form-item-submitted-hear">
            <input type="radio" id="edit-submitted-hear-3" name="submitted[hear]" value="tradeshow" class="form-radio">  <label class="option" for="edit-submitted-hear-3">Tradeshow </label>

          </div>
          <div class="form-item form-type-radio form-item-submitted-hear">
            <input type="radio" id="edit-submitted-hear-4" name="submitted[hear]" value="advertisement" class="form-radio">  <label class="option" for="edit-submitted-hear-4">Advertisement </label>

          </div>
          <div class="form-item form-type-radio form-item-submitted-hear">
            <input type="radio" id="edit-submitted-hear-5" name="submitted[hear]" value="referred_by" class="form-radio">  <label class="option" for="edit-submitted-hear-5">Referred by </label>

          </div>
        </div>
        <div class="col-sm-4 form-item webform-component webform-component-textfield webform-component--association-name" style="display: block;">
          <label class="element-invisible" for="edit-submitted-association-name">Association name </label>
          <input placeholder="Association Name" type="text" id="edit-submitted-association-name" name="submitted[association_name]" value="" size="60" maxlength="128" class="form-text">
        </div>
        <div class="col-sm-4 form-item webform-component webform-component-textfield webform-component--persons-name" style="display: block;">
          <label class="element-invisible" for="edit-submitted-persons-name">Person's name </label>
          <input placeholder="Person's name" type="text" id="edit-submitted-persons-name" name="submitted[persons_name]" value="" size="60" maxlength="128" class="form-text">
        </div>
      </div>
      <div class="form-actions btns-wrap">
        <input type="submit" class="form-submit" value="SuBMIT">
      </div>
      <div class="webform-confirmation">
        <p>Thank you, your submission has been received.</p>
      </div>
    </div>
  </div>
</section>
</div>
<?php include 'tpl/layout/footer.inc'; ?>
</div>
</body>
</html>