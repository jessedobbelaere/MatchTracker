//
//  CompetitionsViewController.h
//  MatchTrackerApp
//
//  Created by Jesse on 10/01/13.
//  Copyright (c) 2013 Jesse. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "PullRefreshTableViewController.h"

@interface CompetitionsViewController : PullRefreshTableViewController

@property (nonatomic, strong) NSArray *competitions;

@end
