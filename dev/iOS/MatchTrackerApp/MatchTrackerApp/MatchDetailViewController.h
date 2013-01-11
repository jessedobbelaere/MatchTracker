//
//  MatchDetailViewController.h
//  MatchTrackerApp
//
//  Created by Jesse on 11/01/13.
//  Copyright (c) 2013 Jesse. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Match.h"
#import "PullRefreshTableViewController.h"

@interface MatchDetailViewController : PullRefreshTableViewController

@property (nonatomic, retain) NSString* identifier;
@property (nonatomic, retain) Match* match;

@property (weak, nonatomic) IBOutlet UILabel *lblHomeScore;
@property (weak, nonatomic) IBOutlet UILabel *lblAwayScore;
@property (weak, nonatomic) IBOutlet UITextView *txtEvents;


@end
