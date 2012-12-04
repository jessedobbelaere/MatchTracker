//
//  FirstViewController.m
//  MatchTrackerApp
//
//  Created by Jesse on 4/12/12.
//  Copyright (c) 2012 Jesse. All rights reserved.
//

#import "FirstViewController.h"
#import <RestKit/RestKit.h>
#import "DataAccess.h"

@interface FirstViewController ()

@end

@implementation FirstViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
    
    
    // RestKit
    // https://github.com/RestKit/RestKit/blob/master/Docs/Object%20Mapping.md#mapping-without-kvc geen key-value coding?
    
    // Create data acccess singleton object
    DataAccess *sharedDataAccess = [DataAccess sharedDataAccess];
    [sharedDataAccess getData];
    
    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
