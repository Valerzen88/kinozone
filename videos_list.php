<?php
include_once("header.php");
?>
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">
                           <div class="btn-group float-right right-action">
                              <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                              </div>
                           </div>
                           <h6>Результаты поиска (найдено: <?php echo $total_count;?>)</h6>
                        </div>
                     </div>
                      <?php
                        foreach ($films_list as $k => $v) {
                            if($v[3]!==null) {
                                echo "<div class=\"col-xl-3 col-sm-6 mb-3\">
                                        <div class=\"channels-card\">
                                        <div class=\"channels-card-image\">
                                        <a href=\"video-page.php?filmId=".$v[1]."\"><img class=\"img-fluid\" src=\"" . $v[7] . "\" alt=\"\"></a>
                                       <div class=\"channels-card-image-btn\"><button type=\"button\" onclick=\"window.location.href='video-page.php?filmId=".$v[1]."'\"
                                       class=\"btn btn-outline-secondary btn-sm\">" . $v[3] . " (".$v[22].")";
                                       if($v[11]>0||$v[13]>0){
                                           echo "<span style='padding-left: 8px;'><i class=\"fas fa-star\"></i>&nbsp;";
                                           if($v[11]>0){echo $v[11];}elseif($v[13]>0){echo $v[13];}
                                           echo "</span>";
                                       }
                                       echo "</a></button></div>
                                       </div>
                                        <div class=\"channels-card-body\">                                  
                                         <div class=\"channels-view\">
                                         " . $v[34] . "
                                        </div>
                                        </div>
                                        </div>
                                    </div>";
                            }
                        }
                      ?>
                      <div class="col-md-12">
                          <nav aria-label="Page navigation example">
                              <ul class="pagination justify-content-center pagination-sm mb-4">
                                  <?php $prev_disabled="";if($page==1) {$prev_disabled=" disabled";}?>
                                  <li class="page-item<?php echo $prev_disabled;?>">
                                      <a class="page-link" href="videos_list.php?p=<?php echo $page-1; ?>" tabindex="-1"><i class="fas fa-angle-left"></i></a>
                                  </li>
                                  <?php for($page_ = 1; $page_<= intval($number_of_pages); $page_++) {
                                      $active="";$link_disabled="";if($page==$page_) {$active=" active";$link_disabled=" disabled";}
                                      $params="";if(isset($_GET["s"])) {$params="s=".$_GET["s"];}elseif (isset($_GET["year"])) {$params="year=".$_GET["year"];}
                                      echo '<li class="page-item'.$active.'"><a class="page-link'.$link_disabled.'" 
                                      href="videos_list.php?'.$params.'&p=' . $page_ . '">' . $page_ . ' </a></li>';
                                  }?>
                                  <?php $next_disabled="";if(intval($page)==intval($number_of_pages)) {$next_disabled=" disabled";}?>
                                  <li class="page-item<?php echo $next_disabled;?>">
                                      <a class="page-link" href="videos_list.php?p=<?php echo $page+1; ?>" tabindex="-1"><i class="fas fa-angle-right"></i></a>
                                  </li>
                              </ul>
                          </nav>
                          <div/>
                      </div>
                  </div>
               <hr>
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">
                           <div class="btn-group float-right right-action">
                              <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                              </div>
                           </div>
                           <h6>Featured Videos</h6>
                        </div>
                     </div>
                     <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="video-card">
                           <div class="video-card-image">
                              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                              <a href="#"><img class="img-fluid" src="img/v5.png" alt=""></a>
                              <div class="time">3:50</div>
                           </div>
                           <div class="video-card-body">
                              <div class="video-title">
                                 <a href="#">There are many variations of passages of Lorem</a>
                              </div>
                              <div class="video-page text-success">
                                 Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                              </div>
                              <div class="video-view">
                                 1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="video-card">
                           <div class="video-card-image">
                              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                              <a href="#"><img class="img-fluid" src="img/v6.png" alt=""></a>
                              <div class="time">3:50</div>
                           </div>
                           <div class="video-card-body">
                              <div class="video-title">
                                 <a href="#">There are many variations of passages of Lorem</a>
                              </div>
                              <div class="video-page text-danger">
                                 Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Unverified"><i class="fas fa-frown text-danger"></i></a>
                              </div>
                              <div class="video-view">
                                 1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="video-card">
                           <div class="video-card-image">
                              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                              <a href="#"><img class="img-fluid" src="img/v7.png" alt=""></a>
                              <div class="time">3:50</div>
                           </div>
                           <div class="video-card-body">
                              <div class="video-title">
                                 <a href="#">There are many variations of passages of Lorem</a>
                              </div>
                              <div class="video-page text-success">
                                 Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                              </div>
                              <div class="video-view">
                                 1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="video-card">
                           <div class="video-card-image">
                              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                              <a href="#"><img class="img-fluid" src="img/v8.png" alt=""></a>
                              <div class="time">3:50</div>
                           </div>
                           <div class="video-card-body">
                              <div class="video-title">
                                 <a href="#">There are many variations of passages of Lorem</a>
                              </div>
                              <div class="video-page text-success">
                                 Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                              </div>
                              <div class="video-view">
                                 1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
                </div>
            </div>
        </div>
            <!-- /.container-fluid -->
<?php include_once("footer.php");?>