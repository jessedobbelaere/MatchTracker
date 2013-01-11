//
//  MatchesViewController.h
//  MatchTrackerApp
//
//  Created by Jesse on 11/01/13.
//  Copyright (c) 2013 Jesse. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Match.h"
#import "PullRefreshTableViewController.h"

@interface MatchesViewController : PullRefreshTableViewController

@property(nonatomic, retain) NSArray* matches;

@end
