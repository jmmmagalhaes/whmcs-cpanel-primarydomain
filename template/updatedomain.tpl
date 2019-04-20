
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><strong>{$domain}</strong> Domain Modification</h3>
  </div>
  <div class="panel-body">


  {if $output}

  {$output}

  {else}

    <div class="well">
      Please note:<br /><br />
      <ul>
        <li>This tool only works for Web Hosting.</li>
        <li>Do not include "www" or "http://" when entering your domain. For example, only type: example.com</li>
        <li>Do not include any folders or subdirectories when entering your domain. For example, example.com/mysite is <u>invalid.</u></li>
        <li>If you've already added your new domain as an Addon Domain or Alias on your account, please remove it before using this tool.</li>
      </ul>
    </div>

    <form class="form-horizontal" method="post">
      <div class="form-group">
        <label class="control-label col-sm-2" for="domain">New Domain: </label>
        <div class="col-sm-10">
          <input required type="text" class="form-control" id="domain" name="domain" placeholder="Enter new domain">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="domain2">Confirm New Domain: </label>
        <div class="col-sm-10"> 
          <input required type="text" class="form-control" id="domain2" name="domain2" placeholder="Enter new domain again">
        </div>
      </div>

      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Submit</button>
        </div>
      </div>
    </form>

  {/if}

  </div>
</div>